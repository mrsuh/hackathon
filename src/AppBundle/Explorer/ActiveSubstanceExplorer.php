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
     * @param $str_name
     * @return ActiveSubstance|null
     */
    public function explore($str_name)
    {
        return $this->repo->findOneBy(['name' => $str_name]);
    }
}

