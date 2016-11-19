<?php

namespace AppBundle\Repository\Statistic;

use AppBundle\Repository\GeneralRepository;

class StatisticRepository extends GeneralRepository
{
    public function findByParams()
    {
        return $this->createQueryBuilder('c')
            ->select('c.id')
            ->getQuery()
            ->getResult();
    }

    public function findByParamsAndLimit()
    {
        return $this->createQueryBuilder('c')
            ->select('c.id')
            ->getQuery()
            ->setFirstResult(0)
            ->setMaxResults(10)
            ->getResult();
    }
}
