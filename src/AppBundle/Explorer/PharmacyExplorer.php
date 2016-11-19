<?php

namespace AppBundle\Explorer;

use AppBundle\Entity\Pharmacy\Pharmacy;
use Doctrine\ORM\EntityManager;

class PharmacyExplorer implements ExplorerInterface
{
    private $repo;
    private $list;

    /**
     * PharmacyExplorer constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->repo = $em->getRepository(Pharmacy::class);
        $this->initList();
    }

    private function initList()
    {
        $this->list = $this->repo->findAll();
    }

    /**
     * @param $str
     * @return Pharmacy|null
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

