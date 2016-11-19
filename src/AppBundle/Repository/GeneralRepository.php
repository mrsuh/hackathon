<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GeneralRepository extends EntityRepository
{
    public function create($obj)
    {
        $this->_em->beginTransaction();
        try {
            $this->_em->persist($obj);
            $this->_em->flush($obj);
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $obj;
    }

    public function update($obj)
    {
        $this->_em->beginTransaction();
        try {
            $this->_em->flush($obj);
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $obj;
    }

    public function remove($obj)
    {
        $this->_em->beginTransaction();
        try {
            $this->_em->remove($obj);
            $this->_em->flush($obj);
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return true;
    }
}