<?php

namespace App\Tzevent\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TzeSlide
 *
 * @ORM\Table(name="tze_slide")
 * @ORM\Entity
 */
class TzeSlide
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="sld_event_title", type="string", length=100, nullable=true)
     */
    private $sldEventTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="sld_event_description", type="text", nullable=true)
     */
    private $sldEventDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="sld_intervenant", type="string", length=100, nullable=true)
     */
    private $sldIntervenant;

    /**
     * @var string
     *
     * @ORM\Column(name="sld_location", type="string", length=100, nullable=true)
     */
    private $sldLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="sld_place", type="string", length=100, nullable=true)
     */
    private $sldPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="sld_image_url", type="string", length=255, nullable=true)
     */
    private $sldImageUrl;

    /**
     * @var \DateTime
     * @ORM\Column(name="sld_event_date", type="datetime" , nullable=true)
     */
    private $sldDate;

    /**
     * @var \DateTime
     * @ORM\Column(name="sld_event_date_fin", type="datetime" , nullable=true)
     */
    private $sldDateFin;

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
    public function setId( $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSldEventTitle()
    {
        return $this->sldEventTitle;
    }

    /**
     * @param string $sldEventTitle
     */
    public function setSldEventTitle( $sldEventTitle)
    {
        $this->sldEventTitle = $sldEventTitle;
    }

    /**
     * @return string
     */
    public function getSldEventDescription()
    {
        return $this->sldEventDescription;
    }

    /**
     * @param string $sldEventDescription
     */
    public function setSldEventDescription( $sldEventDescription)
    {
        $this->sldEventDescription = $sldEventDescription;
    }



    /**
     * @return string
     */
    public function getSldIntervenant()
    {
        return $this->sldIntervenant;
    }

    /**
     * @param string $sldIntervenant
     */
    public function setSldIntervenant( $sldIntervenant)
    {
        $this->sldIntervenant = $sldIntervenant;
    }

    /**
     * @return string
     */
    public function getSldLocation()
    {
        return $this->sldLocation;
    }

    /**
     * @param string $sldLocation
     */
    public function setSldLocation( $sldLocation)
    {
        $this->sldLocation = $sldLocation;
    }

    /**
     * @return string
     */
    public function getSldPlace()
    {
        return $this->sldPlace;
    }

    /**
     * @param string $sldPlace
     */
    public function setSldPlace( $sldPlace)
    {
        $this->sldPlace = $sldPlace;
    }

    /**
     * @return string
     */
    public function getSldImageUrl()
    {
        return $this->sldImageUrl;
    }

    /**
     * @param string $sldImageUrl
     */
    public function setSldImageUrl( $sldImageUrl)
    {
        $this->sldImageUrl = $sldImageUrl;
    }

    /**
     * @return \DateTime
     */
    public function getSldDate()
    {
        return $this->sldDate;
    }

    /**
     * @param \DateTime $sldDate
     */
    public function setSldDate( $sldDate)
    {
        $this->sldDate = $sldDate;
    }

    /**
     * @return \DateTime
     */
    public function getSldDateFin()
    {
        return $this->sldDateFin;
    }

    /**
     * @param \DateTime $sldDateFin
     */
    public function setSldDateFin( $sldDateFin)
    {
        $this->sldDateFin = $sldDateFin;
    }


}
