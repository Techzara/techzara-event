<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/17/19
 * Time: 12:10 AM
 */

namespace App\Shared\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TzeSlide
 *
 * @ORM\Table(name="tze_organisateur")
 * @ORM\Entity
 */
class TzeOrganisateur
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
     * @ORM\ManyToOne(targetEntity="App\Shared\Entity\TzeSlide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actEvent", referencedColumnName="id",nullable=false, onDelete="CASCADE")
     * })
     */
    private $actEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="org_name", type="string", length=100, nullable=true)
     */
    private $orgName;

    /**
     * @var string
     *
     * @ORM\Column(name="org_image", type="string", length=150, nullable=true)
     */
    private $orgImage;


    /**
     * @var string
     *
     * @ORM\Column(name="org_decription", type="string", length=255, nullable=true)
     */
    private $orgDecription;

    /**
     * @var string
     *
     * @ORM\Column(name="org_responsabilite", type="string", length=100, nullable=true)
     */
    private $orgResponsabilite;

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
    public function getOrgName()
    {
        return $this->orgName;
    }

    /**
     * @param string $orgName
     */
    public function setOrgName($orgName)
    {
        $this->orgName = $orgName;
    }

    /**
     * @return string
     */
    public function getOrgImage()
    {
        return $this->orgImage;
    }

    /**
     * @param string $orgImage
     */
    public function setOrgImage($orgImage)
    {
        $this->orgImage = $orgImage;
    }

    /**
     * @return string
     */
    public function getOrgDecription()
    {
        return $this->orgDecription;
    }

    /**
     * @param string $orgDecription
     */
    public function setOrgDecription($orgDecription)
    {
        $this->orgDecription = $orgDecription;
    }

    /**
     * @return string
     */
    public function getOrgResponsabilite()
    {
        return $this->orgResponsabilite;
    }

    /**
     * @param string $orgResponsabilite
     */
    public function setOrgResponsabilite($orgResponsabilite)
    {
        $this->orgResponsabilite = $orgResponsabilite;
    }


}