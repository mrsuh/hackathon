<?php

namespace AppBundle\Collector;

use AppBundle\Client\Http;
use AppBundle\Entity\Source\Source;
use AppBundle\Exception\FactoryException;
use AppBundle\Parser\Source\AcmeParser;
use Doctrine\ORM\EntityManager;

class CollectFactory
{
    private $em;
    private $http_client;
    private $parser_acme;

    public function __construct(EntityManager $em, Http $http_client, AcmeParser $parser_acme)
    {
        $this->em = $em;
        $this->http_client = $http_client;
        $this->parser_acme = $parser_acme;
    }

    public function init(Source $source)
    {
        switch($source->getId()) {
            case Source::ACME:
                return new AcmeCollect(
                    $this->em,
                    $this->http_client,
                    $this->parser_acme
                );
            default:
                throw new FactoryException('Class "Collect" can not be initialize by source id ' . $source->getId());
        }
    }
}

