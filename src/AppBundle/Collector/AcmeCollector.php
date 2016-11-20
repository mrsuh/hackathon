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

    /**
     * AcmeCollector constructor.
     * @param EntityManager $em
     * @param Http $http_client
     * @param AcmeParser $parser
     */
    public function __construct(EntityManager $em, Http $http_client, AcmeParser $parser)
    {
        $this->em = $em;
        $this->repo_statistic = $em->getRepository(Statistic::class);
        $this->http_client = $http_client;
        $this->parser = $parser;
    }

    /**
     * @param Source $source
     * @return bool
     */
    public function collectByAlphabet(Source $source)
    {
        $response = $this->http_client->send(new Request('GET', $source->getUrl()));
        $html = $response->getBody()->getContents();

        $dom = \Sunra\PhpSimple\HtmlDomParser::str_get_html($html);

        foreach ($dom->find('.alphabet a') as $a) {
            $this->collect($source, $a->attr['href']);
        }

        return true;
    }

    /**
     * @param Source $source
     * @param $href
     * @return bool
     */
    public function collect(Source $source, $href)
    {
        $response = $this->http_client->send(new Request('GET', $source->getUrl() . '/' . $href));
        $html = $response->getBody()->getContents();

        $dom = \Sunra\PhpSimple\HtmlDomParser::str_get_html($html);

        $count = count($dom->find('#container a'));
        $index = 0;
        foreach ($dom->find('#container a') as $a) {
            echo trim($a->innertext) . ' | ' . $count . '/' . $index++ . PHP_EOL;

            $this->em->beginTransaction();

            try {

                $response_drug = $this->http_client->send(new Request('GET', $source->getUrl() . '/' . $a->attr['href']));

                $dom_drug = \Sunra\PhpSimple\HtmlDomParser::str_get_html($response_drug->getBody()->getContents());

                $inner_list = $dom_drug->find('.trades option');

                if (!empty($inner_list)) {

                    foreach ($inner_list as $key => $option) {
                        if (0 === $key) {
                            continue;
                        }
                        $inner_response_drug = $this->http_client->send(new Request('GET', $source->getUrl() . '/' . $option->attr['value']));

                        $inner_dom_drug = \Sunra\PhpSimple\HtmlDomParser::str_get_html($inner_response_drug->getBody()->getContents());

                        $this->setStatistics($inner_dom_drug);
                    }
                } else {
                    $this->setStatistics($dom_drug);
                }

                $this->em->commit();
            } catch (\Exception $e) {
                $this->em->rollback();
            }
        }

        return true;
    }

    /**
     * @param \simplehtmldom_1_5\simple_html_dom $dom
     */
    private function setStatistics(\simplehtmldom_1_5\simple_html_dom $dom)
    {
        foreach ($this->parser->parse($dom) as $statistic) {

            $exist_statistic = $this->repo_statistic->findOneBy([
                'pharmacy' => $statistic->getPharmacy()->getId(),
                'drug' => $statistic->getDrug()->getId(),
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
    }
}

