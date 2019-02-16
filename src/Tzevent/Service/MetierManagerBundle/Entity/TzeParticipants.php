<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/16/19
 * Time: 3:38 PM
 */

namespace App\Tzevent\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TzeSlide
 *
 * @ORM\Table(name="tze_participants")
 * @ORM\Entity
 */

class TzeParticipants
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
     *   @ORM\JoinColumn(name="actEvent", referencedColumnName="id")
     * })
     */
    private $actEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="part_universite", type="string", length=100, nullable=true)
     */
    private $partUniversite;

    /**
     * @var string
     *
     * @ORM\Column(name="part_image", type="string", length=100, nullable=true)
     */
    private $partImage;

    /**
     * @var string
     *
     * @ORM\Column(name="part_team", type="string", length=100, nullable=true)
     */
    private $partTeam;

    /**
     * @var string
     * @ORM\Column(name="part_description",type="text" , nullable=true)
     */
    private $partDescription;

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
    public function getPartUniversite()
    {
        return $this->partUniversite;
    }

    /**
     * @param string $partUniversite
     */
    public function setPartUniversite($partUniversite)
    {
        $this->partUniversite = $partUniversite;
    }

    /**
     * @return string
     */
    public function getPartImage()
    {
        return $this->partImage;
    }

    /**
     * @param string $partImage
     */
    public function setPartImage($partImage)
    {
        $this->partImage = $partImage;
    }

    /**
     * @return string
     */
    public function getPartTeam()
    {
        return $this->partTeam;
    }

    /**
     * @param string $partTeam
     */
    public function setPartTeam($partTeam)
    {
        $this->partTeam = $partTeam;
    }

    /**
     * @return string
     */
    public function getPartDescription()
    {
        return $this->partDescription;
    }

    /**
     * @param string $partDescription
     */
    public function setPartDescription($partDescription)
    {
        $this->partDescription = $partDescription;
    }


}