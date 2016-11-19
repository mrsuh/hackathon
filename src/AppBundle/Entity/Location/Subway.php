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
     * @ORM\Column(name="subway_regexp", type="string", length=255)
     */
    private $regexp;

    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Location\City")
     * @ORM\JoinColumn(name="city", referencedColumnName="id")
     */
    private $city;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return string
     */
    public function getRegexp()
    {
        return $this->regexp;
    }

    /**
     * @param $regexp
     * @return $this
     */
    public function setRegexp($regexp)
    {
        $this->regexp = $regexp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }
}

