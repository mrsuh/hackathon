<?php

namespace AppBundle\Parser\Source;

use AppBundle\Client\Http;
use Doctrine\ORM\EntityManager;

class ParseFactory
{
    private $dm_factory;
    private $http_client;
    private $api_service;
    private $geo;
    private $subway;

    public function __construct(EntityManager $em, Http $http_client)
    {
        $this->em = $em;
        $this->http_client = $http_client;
    }

    public function init(ParserConfig $parser)
    {
       switch($parser->getSource()) {
           case ParserConfig::AVITO:
               return new AvitoParser($this->dm_factory, $this->http_client, $this->geo, $this->subway, $parser);
           case ParserConfig::YANDEX:
               return new YandexParser($this->dm_factory, $this->http_client, $this->geo, $this->subway, $parser);
           case ParserConfig::DOMOFOND:
               return new DomofondParser($this->dm_factory, $this->http_client, $this->geo, $this->subway, $parser);
           case ParserConfig::DMIR:
               return new DmirParser($this->dm_factory, $this->http_client, $this->geo, $this->subway, $parser);
           case ParserConfig::IRR:
               return new IrrParser($this->dm_factory, $this->http_client, $this->geo, $this->subway, $parser);
           case ParserConfig::LOCALS:
               return new LocalsParser($this->dm_factory, $this->http_client, $this->geo, $this->subway, $parser);
           case ParserConfig::VK:
               return new VkParser($this->dm_factory, $this->api_service, $this->geo, $this->subway, $parser);
           default:
              throw new ParseFactoryException('Invalid parser source');
       }
    }
}

