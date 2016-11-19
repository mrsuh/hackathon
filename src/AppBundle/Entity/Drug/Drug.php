<?php

namespace AppBundle\Entity\Drug;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drug
 *
 * @ORM\Table(name="drug")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Drug\DrugRepository")
 */
class Drug
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Drug\ActiveSubstance")
     * @ORM\JoinColumn(name="active_substance", referencedColumnName="id")
     */
    private $activeSubstance;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActiveSubstance()
    {
        return $this->activeSubstance;
    }

    /**
     * @param $activeSubstance
     * @return $this
     */
    public function setActiveSubstance($activeSubstance)
    {
        $this->activeSubstance = $activeSubstance;

        return $this;
    }
}

