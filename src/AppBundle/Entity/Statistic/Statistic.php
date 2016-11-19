<?php

namespace AppBundle\Entity\Statistic;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistic
 *
 * @ORM\Table(name="statistic")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Statistic\StatisticRepository")
 */
class Statistic
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
     * @ORM\Column(name="drug", type="string", length=255)
     */
    private $drug;

    /**
     * @var string
     *
     * @ORM\Column(name="pharmacy", type="string", length=255)
     */
    private $pharmacy;

    /**
     * @var string
     *
     * @ORM\Column(name="subway", type="string", length=255)
     */
    private $subway;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;


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
     * Set drug
     *
     * @param string $drug
     *
     * @return Statistic
     */
    public function setDrug($drug)
    {
        $this->drug = $drug;

        return $this;
    }

    /**
     * Get drug
     *
     * @return string
     */
    public function getDrug()
    {
        return $this->drug;
    }

    /**
     * Set pharmacy
     *
     * @param string $pharmacy
     *
     * @return Statistic
     */
    public function setPharmacy($pharmacy)
    {
        $this->pharmacy = $pharmacy;

        return $this;
    }

    /**
     * Get pharmacy
     *
     * @return string
     */
    public function getPharmacy()
    {
        return $this->pharmacy;
    }

    /**
     * Set subway
     *
     * @param string $subway
     *
     * @return Statistic
     */
    public function setSubway($subway)
    {
        $this->subway = $subway;

        return $this;
    }

    /**
     * Get subway
     *
     * @return string
     */
    public function getSubway()
    {
        return $this->subway;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Statistic
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Statistic
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
}

