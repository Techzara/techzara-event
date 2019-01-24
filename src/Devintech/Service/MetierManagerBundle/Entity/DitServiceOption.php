<?php

namespace App\Devintech\Service\MetierManagerBundle\Entity;

use App\Devintech\Service\MetierManagerBundle\Form\DitServiceTypeType;
use App\Devintech\Service\MetierManagerBundle\Utils\ValeurTypeName;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DitService
 *
 * @ORM\Table(name="dit_service_option")
 * @UniqueEntity(fields="srvOptLabel", message="Nom déjà pris")
 * @ORM\Entity
 */
class DitServiceOption
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
     * @ORM\Column(name="srv_opt_label", type="string", length=255, nullable=true)
     */
    private $srvOptLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_opt_desc", type="text", nullable=true)
     */
    private $srvOptDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_opt_type", type="string", length=45, nullable=true)
     */
    private $srvOptType;

    /**
     * @var float
     *
     * @ORM\Column(name="srv_opt_valeur", type="float", nullable=true)
     */
    private $srvOptValeur;

    /**
     * @var DitServiceOptionType
     *
     * @ORM\ManyToOne(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitServiceOptionType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dit_srv_opt_tp_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $ditServiceOptionType;

    /**
     * @var DitServiceOptionValeurType
     *
     * @ORM\OneToOne(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitServiceOptionValeurType",
     *     cascade={"persist"})
     * @ORM\JoinColumn(name="dit_srv_opt_val_tp_id", referencedColumnName="id")
     */
    private $ditServiceOptionValeurType;

    /**
     * @ORM\ManyToMany(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitService", mappedBy="ditServiceOptions", cascade={"persist"})
     */
    private $ditServices;

    /**
     * @ORM\ManyToMany(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitServiceClient", mappedBy="ditServiceOptions", cascade={"persist"})
     */
    private $ditServiceClients;


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
    public function getSrvOptLabel()
    {
        return $this->srvOptLabel;
    }

    /**
     * @param string $srvOptLabel
     */
    public function setSrvOptLabel($srvOptLabel)
    {
        $this->srvOptLabel = $srvOptLabel;
    }

    /**
     * @return string
     */
    public function getSrvOptDesc()
    {
        return $this->srvOptDesc;
    }

    /**
     * @param string $srvOptDesc
     */
    public function setSrvOptDesc($srvOptDesc)
    {
        $this->srvOptDesc = $srvOptDesc;
    }

    /**
     * @return string
     */
    public function getSrvOptType()
    {
        return $this->srvOptType;
    }

    /**
     * @param string $srvOptType
     */
    public function setSrvOptType($srvOptType)
    {
        $this->srvOptType = $srvOptType;
    }

    /**
     * @return float
     */
    public function getSrvOptValeur()
    {
        return $this->srvOptValeur;
    }

    /**
     * @param float $srvOptValeur
     */
    public function setSrvOptValeur($srvOptValeur)
    {
        $this->srvOptValeur = $srvOptValeur;
    }

    /**
     * @return DitServiceOptionType
     */
    public function getDitServiceOptionType()
    {
        return $this->ditServiceOptionType;
    }

    /**
     * @param DitServiceOptionType $ditServiceOptionType
     */
    public function setDitServiceOptionType($ditServiceOptionType)
    {
        $this->ditServiceOptionType = $ditServiceOptionType;
    }

    /**
     * @return DitServiceOptionValeurType
     */
    public function getDitServiceOptionValeurType()
    {
        return $this->ditServiceOptionValeurType;
    }

    /**
     * @param DitServiceOptionValeurType $ditServiceOptionValeurType
     */
    public function setDitServiceOptionValeurType($ditServiceOptionValeurType)
    {
        $this->ditServiceOptionValeurType = $ditServiceOptionValeurType;
    }

    /**
     * @return mixed
     */
    public function getDitServices()
    {
        return $this->ditServices;
    }

    /**
     * @param mixed $ditServices
     */
    public function setDitServices($ditServices)
    {
        $this->ditServices = $ditServices;
    }

    /**
     * @return string
     */
    public function getServiceOptionString()
    {
        return $this->ditServiceOptionType->getSrvOptTpLabel() . ' - '
            . $this->srvOptLabel . ' (' . $this->getServiceValeurString() . ')';
    }

    /**
     * @return string
     */
    public function getServiceValeurString()
    {
        $_option_valeur = empty($this->srvOptValeur) ? 0 : $this->srvOptValeur;

        // Gratuit
        if ($this->ditServiceOptionValeurType->getSrvOptValTpVal() == ValeurTypeName::ID_GRATUIT)
            $_valeur = 'Gratuit';

        // Augmentation en pourcentage
        if ($this->ditServiceOptionValeurType->getSrvOptValTpVal() == ValeurTypeName::ID_POURCENTAGE)
            $_valeur = '+' . $_option_valeur . '%';

        // Augmentation en €
        if ($this->ditServiceOptionValeurType->getSrvOptValTpVal() == ValeurTypeName::ID_EURO)
            $_valeur = '+' . $_option_valeur . '€';

        return $_valeur;
    }

    /**
     * @return mixed
     */
    public function getDitServiceClients()
    {
        return $this->ditServiceClients;
    }

    /**
     * @param mixed $ditServiceClients
     */
    public function setDitServiceClients($ditServiceClients)
    {
        $this->ditServiceClients = $ditServiceClients;
    }
}
