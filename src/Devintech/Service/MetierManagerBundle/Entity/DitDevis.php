<?php

namespace App\Devintech\Service\MetierManagerBundle\Entity;

use App\Devintech\Service\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * DitDevis
 *
 * @ORM\Table(name="dit_devis")
 * @ORM\Entity
 */
class DitDevis
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
     * @ORM\Column(name="dv_sujet", type="string", length=100, nullable=true)
     */
    private $dvSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="dv_desc", type="text", nullable=true)
     */
    private $dvDesc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dv_date", type="datetime", nullable=true)
     */
    private $dvDate;

    /**
     * @var string
     *
     * @ORM\Column(name="dv_pj", type="string", length=255, nullable=true)
     */
    private $dvPj;

    /**
     * @var DitClient
     *
     * @ORM\ManyToOne(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitClient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dit_clt_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $ditClient;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Devintech\Service\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dit_usr_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $ditUser;


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
    public function getDvSujet()
    {
        return $this->dvSujet;
    }

    /**
     * @param string $dvSujet
     */
    public function setDvSujet($dvSujet)
    {
        $this->dvSujet = $dvSujet;
    }

    /**
     * @return string
     */
    public function getDvDesc()
    {
        return $this->dvDesc;
    }

    /**
     * @param string $dvDesc
     */
    public function setDvDesc($dvDesc)
    {
        $this->dvDesc = $dvDesc;
    }

    /**
     * @return \DateTime
     */
    public function getDvDate()
    {
        return $this->dvDate;
    }

    /**
     * @param \DateTime $dvDate
     */
    public function setDvDate($dvDate)
    {
        $this->dvDate = $dvDate;
    }

    /**
     * @return string
     */
    public function getDvPj()
    {
        return $this->dvPj;
    }

    /**
     * @param string $dvPj
     */
    public function setDvPj($dvPj)
    {
        $this->dvPj = $dvPj;
    }

    /**
     * @return DitClient
     */
    public function getDitClient()
    {
        return $this->ditClient;
    }

    /**
     * @param DitClient $ditClient
     */
    public function setDitClient($ditClient)
    {
        $this->ditClient = $ditClient;
    }

    /**
     * @return User
     */
    public function getDitUser()
    {
        return $this->ditUser;
    }

    /**
     * @param User $ditUser
     */
    public function setDitUser($ditUser)
    {
        $this->ditUser = $ditUser;
    }
}
