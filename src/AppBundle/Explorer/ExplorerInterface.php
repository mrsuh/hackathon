<?php

namespace AppBundle\Explorer;

use Doctrine\ORM\EntityManager;

interface ExplorerInterface
{
    /**
     * ExplorerInterface constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em);

    /**
     * @param $str
     * @return Object|null
     */
    public function explore($str);
}

