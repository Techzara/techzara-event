<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/15/19
 * Time: 4:27 PM
 */

namespace App\Shared\Entity;


use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * TzeSlide
 *
 * @ORM\Table(name="tze_event_activite")
 * @ORM\Entity
 */
class TzeEvenementActivite
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
     * @ParamConverter("event", options={"id" = "id"})
     * @ORM\ManyToOne(targetEntity="App\Shared\Entity\TzeSlide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actEvent", referencedColumnName="id" , nullable=false , onDelete="CASCADE")
     * })
     */
    private $actEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="act_title", type="string", length=100, nullable=true)
     */
    private $actTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="act_description", type="text" , nullable=true)
     */
    private $actDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="act_debut", type="datetime" , nullable=true)
     */
    private $actDebut;

    /**
     * @var string
     *
     * @ORM\Column(name="act_fin", type="datetime" , nullable=true)
     */
    private $actFin;

    /**
     * @var string
     * @ORM\Column(name="act_image" , type="string", length=255, nullable=true)
     */
    private $actImage;

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
    public function getActTitle()
    {
        return $this->actTitle;
    }

    /**
     * @param string $actTitle
     */
    public function setActTitle($actTitle)
    {
        $this->actTitle = $actTitle;
    }

    /**
     * @return string
     */
    public function getActDescription()
    {
        return $this->actDescription;
    }

    /**
     * @param string $actDescription
     */
    public function setActDescription($actDescription)
    {
        $this->actDescription = $actDescription;
    }

    /**
     * @return string
     */
    public function getActDebut()
    {
        return $this->actDebut;
    }

    /**
     * @param string $actDebut
     */
    public function setActDebut($actDebut)
    {
        $this->actDebut = $actDebut;
    }

    /**
     * @return string
     */
    public function getActFin()
    {
        return $this->actFin;
    }

    /**
     * @param string $actFin
     */
    public function setActFin($actFin)
    {
        $this->actFin = $actFin;
    }

    /**
     * @return string
     */
    public function getActImage()
    {
        return $this->actImage;
    }

    /**
     * @param string $actImage
     */
    public function setActImage($actImage)
    {
        $this->actImage = $actImage;
    }

}