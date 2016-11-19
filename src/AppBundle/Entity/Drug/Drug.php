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
     * @var int
     *
     * @ORM\Column(name="фсеactiveSubstance", type="integer")
     */
    private $фсеactiveSubstance;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Drug
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set фсеactiveSubstance
     *
     * @param integer $фсеactiveSubstance
     *
     * @return Drug
     */
    public function setфсеactiveSubstance($фсеactiveSubstance)
    {
        $this->фсеactiveSubstance = $фсеactiveSubstance;

        return $this;
    }

    /**
     * Get фсеactiveSubstance
     *
     * @return int
     */
    public function getфсеactiveSubstance()
    {
        return $this->фсеactiveSubstance;
    }
}

