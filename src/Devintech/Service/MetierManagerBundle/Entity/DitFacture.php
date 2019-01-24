<?php

namespace App\Devintech\Service\MetierManagerBundle\Entity;

use App\Devintech\Service\MetierManagerBundle\Utils\EtatFactureName;
use Doctrine\ORM\Mapping as ORM;

/**
 * DitRole
 *
 * @ORM\Table(name="dit_facture")
 * @ORM\Entity
 */
class DitFacture
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
     * @var \DateTime
     *
     * @ORM\Column(name="fct_date", type="datetime", nullable=true)
     */
    private $fctDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="fct_status", type="smallint", nullable=true)
     */
    private $fctStatus;

    /**
     * @var DitServiceClient
     *
     * @ORM\ManyToOne(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitServiceClient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dit_srv_clt_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $ditServiceClient;


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
     * @return \DateTime
     */
    public function getFctDate()
    {
        return $this->fctDate;
    }

    /**
     * @param \DateTime $fctDate
     */
    public function setFctDate($fctDate)
    {
        $this->fctDate = $fctDate;
    }

    /**
     * @return int
     */
    public function getFctStatus()
    {
        return $this->fctStatus;
    }

    /**
     * @param int $fctStatus
     */
    public function setFctStatus($fctStatus)
    {
        $this->fctStatus = $fctStatus;
    }

    /**
     * @return DitServiceClient
     */
    public function getDitServiceClient()
    {
        return $this->ditServiceClient;
    }

    /**
     * @param DitServiceClient $ditServiceClient
     */
    public function setDitServiceClient($ditServiceClient)
    {
        $this->ditServiceClient = $ditServiceClient;
    }

    /**
     * @return string
     */
    public function getStatusString()
    {
        return EtatFactureName::$VALEUR_TYPE[$this->fctStatus];
    }
}
