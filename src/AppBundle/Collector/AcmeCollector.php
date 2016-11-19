<?php

namespace AppBundle\Collector;

use AppBundle\Client\Http;
use AppBundle\Entity\Source\Source;
use AppBundle\Entity\Statistic\Statistic;
use AppBundle\Parser\AcmeParser;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Request;

class AcmeCollector
{
    private $em;
    private $repo_statistic;
    private $http_client;
    private $parser;

    public function __construct(EntityManager $em, Http $http_client, AcmeParser $parser)
    {
        $this->em = $em;
        $this->repo_statistic = $em->getRepository(Statistic::class);
        $this->http_client = $http_client;
        $this->parser = $parser;
    }

    public function collectByAlphabet(Source $source)
    {
        $response = $this->http_client->send(new Request('GET', $source->getUrl()));
        $html = $response->getBody()->getContents();

        $dom = \Sunra\PhpSimple\HtmlDomParser::str_get_html($html);

        foreach($dom->find('.alphabet a') as $a) {

            $symbol = $a->innertext . PHP_EOL;
            $this->collect($source, $a->attr['href'], $symbol);
        }

        return true;
    }

    public function collect($source, $href, $symbol)
    {
        $response = $this->http_client->send(new Request('GET', $source->getUrl() . '/' . $href));
        $html = $response->getBody()->getContents();

        $dom = \Sunra\PhpSimple\HtmlDomParser::str_get_html($html);

        $count = count($dom->find('#container a'));
        $index = 0;
        foreach ($dom->find('#container a') as $a) {
            echo trim($symbol) . ' | ' . $count . '/' . $index++ . PHP_EOL;

            $this->em->beginTransaction();

            try {

                $response_drug = $this->http_client->send(new Request('GET', $source->getUrl() . '/' . $a->attr['href']));

                $dom_drug = \Sunra\PhpSimple\HtmlDomParser::str_get_html($response_drug->getBody()->getContents());

                foreach ($this->parser->parse($dom_drug) as $statistic) {

                    $exist_statistic = $this->repo_statistic->findOneBy([
                        'pharmacy' => $statistic->getPharmacy()->getId(),
                        'drug'     => $statistic->getDrug()->getId(),
                    ]);

                    if ($exist_statistic) {
                        $this->repo_statistic->update(
                            $exist_statistic
                                ->setPrice($statistic->getPrice())
                                ->setDate($statistic->getDate())
                        );
                    } else {
                        $this->repo_statistic->create($statistic);
                    }
                }

                $this->em->commit();
            } catch (\Exception $e) {
                $this->em->rollback();
            }
        }

        return true;
    }
}

