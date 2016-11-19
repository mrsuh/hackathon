<?php

namespace AppBundle\Explorer;

use AppBundle\Entity\Drug\ActiveSubstance;
use Doctrine\ORM\EntityManager;

class ActiveSubstanceExplorer implements ExplorerInterface
{
    private $repo;
    private $list;

    /**
     * DrugExplorer constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->repo = $em->getRepository(ActiveSubstance::class);
        $this->initList();
    }

    private function initList()
    {
        $this->list = $this->repo->findAll();
    }

    /**
     * @param $str
     * @return ActiveSubstance|null
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

