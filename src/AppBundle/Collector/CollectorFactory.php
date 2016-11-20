<?php

namespace AppBundle\Collector;

use AppBundle\Client\Http;
use AppBundle\Entity\Source\Source;
use AppBundle\Exception\FactoryException;
use AppBundle\Parser\AcmeParser;
use Doctrine\ORM\EntityManager;

class CollectorFactory
{
    private $em;
    private $http_client;
    private $parser_acme;

    /**
     * CollectorFactory constructor.
     * @param EntityManager $em
     * @param Http $http_client
     * @param AcmeParser $parser_acme
     */
    public function __construct(EntityManager $em, Http $http_client, AcmeParser $parser_acme)
    {
        $this->em = $em;
        $this->http_client = $http_client;
        $this->parser_acme = $parser_acme;
    }

    /**
     * @param Source $source
     * @return bool
     * @throws FactoryException
     */
    public function collect(Source $source)
    {
        switch($source->getId()) {
            case Source::ACME:
                return (new AcmeCollector(
                    $this->em,
                    $this->http_client,
                    $this->parser_acme
                ))->collectByAlphabet($source);
            default:
                throw new FactoryException('Class "Collect" can not be initialize by source id ' . $source->getId());
        }
    }
}

