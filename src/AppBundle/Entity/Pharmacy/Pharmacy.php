<?php

namespace AppBundle\Entity\Pharmacy;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pharmacy
 *
 * @ORM\Table(name="pharmacy")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Pharmacy\PharmacyRepository")
 */
class Pharmacy
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
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(name="geoLat", type="float")
     */
    private $geoLat;

    /**
     * @var float
     *
     * @ORM\Column(name="geoLng", type="float")
     */
    private $geoLng;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Location\Subway")
     * @ORM\JoinColumn(name="subway", referencedColumnName="id")
     */
    private $subway;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2047)
     */
    private $description;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return float
     */
    public function getGeoLat()
    {
        return $this->geoLat;
    }

    /**
     * @param $geoLat
     * @return $this
     */
    public function setGeoLat($geoLat)
    {
        $this->geoLat = $geoLat;

        return $this;
    }

    /**
     * @return float
     */
    public function getGeoLng()
    {
        return $this->geoLng;
    }

    /**
     * @param $geoLng
     * @return $this
     */
    public function setGeoLng($geoLng)
    {
        $this->geoLng = $geoLng;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return int
     */
    public function getSubway()
    {
        return $this->subway;
    }

    /**
     * @param $subway
     * @return $this
     */
    public function setSubway($subway)
    {
        $this->subway = $subway;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}

