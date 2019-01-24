<?php

namespace App\Devintech\Service\MetierManagerBundle\Entity;

use App\Devintech\Service\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * DitClient
 *
 * @ORM\Table(name="dit_user_service_client")
 * @ORM\Entity
 */
class DitUserServiceClient
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
     * @ORM\Column(name="usr_srv_clt_date_debut", type="datetime", nullable=true)
     */
    private $usrSrvCltDateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_srv_clt_date_attribution", type="datetime", nullable=true)
     */
    private $usrSrvCltDateAttribution;

    /**
     * @var float
     *
     * @ORM\Column(name="usr_srv_clt_estimation", type="float", nullable=true)
     */
    private $usrSrvCltEstimation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_srv_clt_date_finalisation", type="datetime", nullable=true)
     */
    private $usrSrvCltDateFinalisation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Devintech\Service\UserBundle\Entity\User", inversedBy="ditUserServiceClients")
     * @ORM\JoinTable(name="dit_user_service_client_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="dit_usr_srv_clt_id", referencedColumnName="id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dit_usr_id", referencedColumnName="id", onDelete="cascade")
     *   }
     * )
     */
    private $ditUsers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Devintech\Service\UserBundle\Entity\User")
     * @ORM\JoinTable(name="dit_user_service_client_tester",
     *   joinColumns={
     *     @ORM\JoinColumn(name="dit_usr_srv_clt_id", referencedColumnName="id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dit_tst_id", referencedColumnName="id", onDelete="cascade")
     *   }
     * )
     */
    private $ditTesters;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Devintech\Service\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dit_usr_admin_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $ditAdmin;

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
     * Constructor
     */
    public function __construct()
    {
        $this->usrSrvCltDateAttribution = new \DateTime();
    }

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
    public function getUsrSrvCltDateDebut()
    {
        return $this->usrSrvCltDateDebut;
    }

    /**
     * @param \DateTime $usrSrvCltDateDebut
     */
    public function setUsrSrvCltDateDebut($usrSrvCltDateDebut)
    {
        $this->usrSrvCltDateDebut = $usrSrvCltDateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getUsrSrvCltDateAttribution()
    {
        return $this->usrSrvCltDateAttribution;
    }

    /**
     * @param \DateTime $usrSrvCltDateAttribution
     */
    public function setUsrSrvCltDateAttribution($usrSrvCltDateAttribution)
    {
        $this->usrSrvCltDateAttribution = $usrSrvCltDateAttribution;
    }

    /**
     * @return float
     */
    public function getUsrSrvCltEstimation()
    {
        return $this->usrSrvCltEstimation;
    }

    /**
     * @param float $usrSrvCltEstimation
     */
    public function setUsrSrvCltEstimation($usrSrvCltEstimation)
    {
        $this->usrSrvCltEstimation = $usrSrvCltEstimation;
    }

    /**
     * @return \DateTime
     */
    public function getUsrSrvCltDateFinalisation()
    {
        return $this->usrSrvCltDateFinalisation;
    }

    /**
     * @param \DateTime $usrSrvCltDateFinalisation
     */
    public function setUsrSrvCltDateFinalisation($usrSrvCltDateFinalisation)
    {
        $this->usrSrvCltDateFinalisation = $usrSrvCltDateFinalisation;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDitUsers()
    {
        return $this->ditUsers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $ditUsers
     */
    public function setDitUsers($ditUsers)
    {
        $this->ditUsers = $ditUsers;
    }

    /**
     * @return User
     */
    public function getDitAdmin()
    {
        return $this->ditAdmin;
    }

    /**
     * @param User $ditAdmin
     */
    public function setDitAdmin($ditAdmin)
    {
        $this->ditAdmin = $ditAdmin;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDitTesters()
    {
        return $this->ditTesters;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $ditTesters
     */
    public function setDitTesters($ditTesters)
    {
        $this->ditTesters = $ditTesters;
    }
}
