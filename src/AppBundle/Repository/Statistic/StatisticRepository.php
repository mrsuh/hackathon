<?php

namespace AppBundle\Repository\Statistic;

use AppBundle\Repository\GeneralRepository;

class StatisticRepository extends GeneralRepository
{
    public function findByParams($name, $price_from, $price_to, $subway, $order)
    {
        $query_str = '
         SELECT s.id as id FROM AppBundle\Entity\Statistic\Statistic s
              JOIN AppBundle\Entity\Drug\Drug d WITH s.drug = d.id
              LEFT JOIN AppBundle\Entity\Drug\ActiveSubstance asub WITH d.activeSubstance = asub.id
              LEFT JOIN AppBundle\Entity\Location\Subway sub WITH s.subway = sub.id
              JOIN AppBundle\Entity\Pharmacy\Pharmacy p WITH s.pharmacy = p.id WHERE 2>1
        ';

        $parameters = [];
        if(null !== $name) {
            $query_str .= " AND (d.name LIKE :name OR asub.name LIKE :name)";
            $parameters['name'] = '%' . $name . '%';
        }

        if(null !== $price_from) {
            $query_str .= " AND s.price >= :price_from";
            $parameters['price_from'] = $price_from;
        }

        if(null !== $price_to) {
            $query_str .= " AND s.price <= :price_to";
            $parameters['price_to'] = $price_to;
        }

        if(!empty($subway)) {
            $ids = implode(',', $subway);
            $query_str .= " AND s.subway IN (:ids)";
            $parameters['ids'] = $ids;
        }

        $query_str .= " ORDER BY s.price " . ($order === 1 ? 'ASC' : 'DESC');

        return $this->_em
            ->createQuery($query_str)
            ->setParameters($parameters)
            ->getResult();
    }

    public function findByParamsAndLimit($name, $price_from, $price_to, $subway, $order, $items_on_page, $page = 1)
    {
        $query_str = '
         SELECT s.id as id, d.name as drug_name, p.name as pharmacy_name, p.address as pharmacy_address, p.geoLng as geo_lat, p.geoLat as geo_lng, sub.name as subway_name, s.price as price FROM AppBundle\Entity\Statistic\Statistic s
              JOIN AppBundle\Entity\Drug\Drug d WITH s.drug = d.id
              LEFT JOIN AppBundle\Entity\Drug\ActiveSubstance asub WITH d.activeSubstance = asub.id
              LEFT JOIN AppBundle\Entity\Location\Subway sub WITH s.subway = sub.id
              JOIN AppBundle\Entity\Pharmacy\Pharmacy p WITH s.pharmacy = p.id WHERE 2>1
        ';

        $parameters = [];
        if(null !== $name) {
            $query_str .= " AND (d.name LIKE :name OR asub.name LIKE :name)";
            $parameters['name'] = '%' . $name . '%';
        }

        if(null !== $price_from) {
            $query_str .= " AND s.price >= :price_from";
            $parameters['price_from'] = $price_from;
        }

        if(null !== $price_to) {
            $query_str .= " AND s.price <= :price_to";
            $parameters['price_to'] = $price_to;
        }

        if(!empty($subway)) {
            $ids = implode(',', $subway);
            $query_str .= " AND s.subway IN (:ids)";
            $parameters['ids'] = $ids;
        }

        $query_str .= " ORDER BY s.price " . ($order === 1 ? 'ASC' : 'DESC');

        return $this->_em
            ->createQuery($query_str)
            ->setFirstResult($items_on_page * ($page - 1))
            ->setMaxResults($items_on_page)
            ->setParameters($parameters)
            ->getResult();
    }
}
