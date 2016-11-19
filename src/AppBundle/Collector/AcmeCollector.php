<?php

namespace AppBundle\Collector;

use AppBundle\Client\Http;
use AppBundle\Parser\Source\AcmeParser;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Request;

class AcmeCollect
{
    private $em;
    private $http_client;
    private $parser;

    public function __construct(EntityManager $em, Http $http_client, AcmeParser $parser)
    {
        $this->em = $em;
        $this->http_client = $http_client;
        $this->parser = $parser;
    }

    public function collect()
    {
        $response = $this->getContainer()->get('client.http')->send(new Request('GET', 'http://www.acmespb.ru/alphabet.php?f=%D0%90'));
        $html = $response->getBody()->getContents();

        $dom = \Sunra\PhpSimple\HtmlDomParser::str_get_html($html);

        foreach($dom->find('#container a') as $a) {
            $href = $a->attr['href'];

            $response_drug = $this->getContainer()->get('client.http')->send(new Request('GET', 'http://www.acmespb.ru/' . $href));


            $html_drug = $response_drug->getBody()->getContents();

            $dom_drug = \Sunra\PhpSimple\HtmlDomParser::str_get_html($html_drug);


            echo $dom_drug->find('.nameblock .drug', 0)->innertext . PHP_EOL;
            echo $dom_drug->find('.filters p', 0)->innertext . PHP_EOL;

            foreach($dom_drug->find('#container .trow') as $key => $row) {

                if($key === 0) {
                    continue;
                }

                echo 'name: ' . $row->find('.name p', 0)->innertext . PHP_EOL;
                echo 'pharm: ' . $row->find('.pharm a', 0)->innertext . PHP_EOL;
                echo 'address: ' . $row->find('.address a', 0)->innertext . PHP_EOL;
                echo 'date: ' . $row->find('.date', 0)->innertext . PHP_EOL;
                echo 'price: ' . $row->find('.pricefull', 0)->innertext . PHP_EOL;

                echo '---------------------------' . PHP_EOL;
            }
            break;
        }
    }
}

