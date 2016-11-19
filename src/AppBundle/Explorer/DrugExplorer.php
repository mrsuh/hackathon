<?php

namespace AppBundle\Explorer;

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
     * @param $str_name
     * @return Drug|null
     */
    public function explore($str_name)
    {
        return $this->repo->findOneBy(['name' => $str_name]);
    }
}

