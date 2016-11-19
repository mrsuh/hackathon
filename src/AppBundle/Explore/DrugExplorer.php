<?php

namespace AppBundle\Parser\Source;

use AppBundle\Entity\Drug\Drug;
use Doctrine\ORM\EntityManager;

class DrugExplorer implements ExplorerInterface
{
    private $repo;
    private $list;

    /**
     * DrugExplorer constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->repo = $em->getRepository(Drug::class);
        $this->initList();
    }

    private function initList()
    {
        $this->list = $this->repo->findAll();
    }

    /**
     * @param $str
     * @return Drug|null
     */
    public function explore($str)
    {
        foreach($this->list as $item) {
            if(mb_stripos($item->getName(), $str)) {
                return $item;
            }
        }

        return null;
    }
}

