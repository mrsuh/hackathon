<?php

namespace AppBundle\Explorer;

use AppBundle\Entity\Location\Subway;
use Doctrine\ORM\EntityManager;

class SubwayExplorer implements ExplorerInterface
{
    private $repo;
    private $list;

    /**
     * SubwayExplorer constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->repo = $em->getRepository(Subway::class);
        $this->initList();
    }

    private function initList()
    {
        $this->list = $this->repo->findAll();
    }

    /**
     * @param $str_raw
     * @return Subway|null
     */
    public function explore($str_raw)
    {
        $str = mb_strtolower($str_raw);
        foreach($this->list as $item) {
            if(1 === preg_match($item->getRegexp(), $str)) {
                return $item;
            }
        }

        return null;
    }
}

