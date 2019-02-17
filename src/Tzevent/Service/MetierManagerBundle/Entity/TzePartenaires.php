<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/16/19
 * Time: 9:19 PM
 */

namespace App\Tzevent\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TzeSlide
 *
 * @ORM\Table(name="tze_partenaires")
 * @ORM\Entity
 */
class TzePartenaires
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
     * @var TzeSlide
     * @ORM\ManyToOne(targetEntity="App\Tzevent\Service\MetierManagerBundle\Entity\TzeSlide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actEvent", referencedColumnName="id",nullable=false, onDelete="CASCADE")
     * })
     */
    private $actEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="parte_entite", type="string", length=100, nullable=true)
     */
    private $parteEntite;

    /**
     * @var string
     *
     * @ORM\Column(name="parte_image", type="string", length=100, nullable=true)
     */
    private $parteImage;

    /**
     * @var string
     *
     * @ORM\Column(name="parte_location", type="string", length=100, nullable=true)
     */
    private $parteLocation;

    /**
     * @var string
     * @ORM\Column(name="parte_contribution", type="text" , nullable=true)
     */
    private $parteContribution;

    /**
     * @var string
     * @ORM\Column(name="parte_facebook", type="string", length=100, nullable=true)
     */
    private $parteFacebook;

    /**
     * @var string
     * @ORM\Column(name="parteweb_site", type="string", length=100, nullable=true)
     */
    private $partewebSite;

    /**
     * @var string
     * @ORM\Column(name="parte_description", type="text" , nullable=true)
     */
    private $parteDescription;

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
     * @return TzeSlide
     */
    public function getActEvent()
    {
        return $this->actEvent;
    }

    /**
     * @param TzeSlide $actEvent
     */
    public function setActEvent($actEvent)
    {
        $this->actEvent = $actEvent;
    }

    /**
     * @return string
     */
    public function getParteEntite()
    {
        return $this->parteEntite;
    }

    /**
     * @param string $parteEntite
     */
    public function setParteEntite($parteEntite)
    {
        $this->parteEntite = $parteEntite;
    }

    /**
     * @return string
     */
    public function getParteImage()
    {
        return $this->parteImage;
    }

    /**
     * @param string $parteImage
     */
    public function setParteImage($parteImage)
    {
        $this->parteImage = $parteImage;
    }

    /**
     * @return string
     */
    public function getParteLocation()
    {
        return $this->parteLocation;
    }

    /**
     * @param string $parteLocation
     */
    public function setParteLocation($parteLocation)
    {
        $this->parteLocation = $parteLocation;
    }

    /**
     * @return string
     */
    public function getParteContribution()
    {
        return $this->parteContribution;
    }

    /**
     * @param string $parteContribution
     */
    public function setParteContribution($parteContribution)
    {
        $this->parteContribution = $parteContribution;
    }

    /**
     * @return string
     */
    public function getParteFacebook()
    {
        return $this->parteFacebook;
    }

    /**
     * @param string $parteFacebook
     */
    public function setParteFacebook($parteFacebook)
    {
        $this->parteFacebook = $parteFacebook;
    }

    /**
     * @return string
     */
    public function getPartewebSite()
    {
        return $this->partewebSite;
    }

    /**
     * @param string $partewebSite
     */
    public function setPartewebSite($partewebSite)
    {
        $this->partewebSite = $partewebSite;
    }

    /**
     * @return string
     */
    public function getParteDescription()
    {
        return $this->parteDescription;
    }

    /**
     * @param string $parteDescription
     */
    public function setParteDescription($parteDescription)
    {
        $this->parteDescription = $parteDescription;
    }

}