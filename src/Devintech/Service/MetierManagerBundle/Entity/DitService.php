<?php

namespace App\Devintech\Service\MetierManagerBundle\Entity;

use App\Devintech\Service\MetierManagerBundle\Form\DitServiceTypeType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * DitService
 *
 * @ORM\Table(name="dit_service")
 * @UniqueEntity(fields="srvLabel", message="Ce source d'energie existe déjà")
 * @ORM\Entity
 */
class DitService
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
     * @ORM\Column(name="srv_label", type="string", length=255, nullable=true)
     */
    private $srvLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_desc", type="text", nullable=true)
     */
    private $srvDesc;

    /**
     * @var float
     *
     * @ORM\Column(name="srv_prix", type="float", nullable=true)
     */
    private $srvPrix;

    /**
     * @var float
     *
     * @ORM\Column(name="srv_reduction", type="float", nullable=true)
     */
    private $srvReduction;

    /**
     * @Gedmo\Slug(fields={"srvLabel"}, updatable=true)
     * @ORM\Column(name="srv_slug", type="string", length=255)
     */
    private $srvSlug;

    /**
     * @var DitServiceTypeType
     *
     * @ORM\ManyToOne(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitServiceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dit_srv_tp_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $ditServiceType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitServiceOption", inversedBy="ditServices")
     * @ORM\JoinTable(name="dit_service_service_option",
     *   joinColumns={
     *     @ORM\JoinColumn(name="dit_srv_id", referencedColumnName="id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dit_srv_opt_id", referencedColumnName="id", onDelete="cascade")
     *   }
     * )
     */
    private $ditServiceOptions;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSrvLabel()
    {
        return $this->srvLabel;
    }

    /**
     * @param string $srvLabel
     */
    public function setSrvLabel($srvLabel)
    {
        $this->srvLabel = $srvLabel;
    }

    /**
     * @return string
     */
    public function getSrvDesc()
    {
        return $this->srvDesc;
    }

    /**
     * @param string $srvDesc
     */
    public function setSrvDesc($srvDesc)
    {
        $this->srvDesc = $srvDesc;
    }

    /**
     * @return float
     */
    public function getSrvPrix()
    {
        return $this->srvPrix;
    }

    /**
     * @param float $srvPrix
     */
    public function setSrvPrix($srvPrix)
    {
        $this->srvPrix = $srvPrix;
    }

    /**
     * @return float
     */
    public function getSrvReduction()
    {
        return $this->srvReduction;
    }

    /**
     * @param float $srvReduction
     */
    public function setSrvReduction($srvReduction)
    {
        $this->srvReduction = $srvReduction;
    }

    /**
     * @return DitServiceTypeType
     */
    public function getDitServiceType()
    {
        return $this->ditServiceType;
    }

    /**
     * @param DitServiceTypeType $ditServiceType
     */
    public function setDitServiceType($ditServiceType)
    {
        $this->ditServiceType = $ditServiceType;
    }

    /**
     * @return mixed
     */
    public function getDitServiceOptions()
    {
        return $this->ditServiceOptions;
    }

    /**
     * @param mixed $ditServiceOptions
     */
    public function setDitServiceOptions($ditServiceOptions)
    {
        $this->ditServiceOptions = $ditServiceOptions;
    }

    /**
     * @return string
     */
    public function getSrvLabelString()
    {
        return $this->srvLabel . ' (' . $this->srvPrix . ' €)';
    }

    /**
     * @return mixed
     */
    public function getSrvSlug()
    {
        return $this->srvSlug;
    }

    /**
     * @param mixed $srvSlug
     */
    public function setSrvSlug($srvSlug)
    {
        $this->srvSlug = $srvSlug;
    }
}
