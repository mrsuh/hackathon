<?php

namespace AppBundle\Entity\Location;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subway
 *
 * @ORM\Table(name="subway")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Location\SubwayRepository")
 */
class Subway
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
     * @var string
     *
     * @ORM\Column(name="subwayRegexp", type="string", length=255)
     */
    private $subwayRegexp;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;


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
     * @return Subway
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
     * Set subwayRegexp
     *
     * @param string $subwayRegexp
     *
     * @return Subway
     */
    public function setSubwayRegexp($subwayRegexp)
    {
        $this->subwayRegexp = $subwayRegexp;

        return $this;
    }

    /**
     * Get subwayRegexp
     *
     * @return string
     */
    public function getSubwayRegexp()
    {
        return $this->subwayRegexp;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Subway
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
}

