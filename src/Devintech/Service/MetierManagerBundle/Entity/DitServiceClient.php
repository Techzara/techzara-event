<?php

namespace App\Devintech\Service\MetierManagerBundle\Entity;

use App\Devintech\Service\MetierManagerBundle\Utils\EtatServiceProject;
use App\Devintech\Service\MetierManagerBundle\Utils\EtatServiceValidation;
use App\Devintech\Service\MetierManagerBundle\Utils\PathName;
use App\Devintech\Service\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * DitRole
 *
 * @ORM\Table(name="dit_service_client")
 * @ORM\Entity
 */
class DitServiceClient
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
     * @var boolean
     *
     * @ORM\Column(name="srv_clt_is_payed", type="boolean", nullable=true)
     */
    private $srvCltIsPayed = false;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_clt_payment_type", type="string", length=45, nullable=true)
     */
    private $srvCltPaymentType;

    /**
     * @var boolean
     *
     * @ORM\Column(name="srv_clt_payment_is_facture", type="boolean", nullable=true)
     */
    private $srvCltPaymentIsFacture = false;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_clt_project_link", type="string", length=255, nullable=true)
     */
    private $srvCltProjectLink;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="srv_clt_date", type="datetime", nullable=true)
     */
    private $srvCltDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="srv_clt_date_livraison_prev", type="datetime", nullable=true)
     */
    private $srvCltDateLivraisonPrev;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="srv_clt_date_livraison", type="datetime", nullable=true)
     */
    private $srvCltDateLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_clt_desc", type="text", nullable=true)
     */
    private $srvCltDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_clt_lien_code_source", type="string", length=255, nullable=true)
     */
    private $srvCltLienCodeSource;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_clt_lien_livre", type="string", length=255, nullable=true)
     */
    private $srvCltLienLivre;

    /**
     * @var integer
     *
     * @ORM\Column(name="srv_clt_nbr_page", type="integer", nullable=true)
     */
    private $srvCltNbrPage = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="srv_clt_nbr_page_decline", type="integer", nullable=true)
     */
    private $srvCltNbrPageDecline = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="srv_clt_prix", type="float", nullable=true)
     */
    private $srvCltPrix;

    /**
     * @var integer
     *
     * @ORM\Column(name="srv_clt_status_validation", type="smallint", options={"default" = 0}, nullable=true)
     */
    private $srvCltStatusValidation = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="srv_clt_status_project", type="smallint", options={"default" = 0}, nullable=true)
     */
    private $srvCltStatusProject = 0;

    /**
     * @var DitService
     *
     * @ORM\ManyToOne(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitService")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dit_srv_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $ditService;

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
     * @ORM\ManyToOne(targetEntity="App\Devintech\Service\UserBundle\Entity\User", inversedBy="ditServiceClients")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dit_usr_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $ditUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitServiceOption", inversedBy="ditServiceClients")
     * @ORM\JoinTable(name="dit_service_client_service_option",
     *   joinColumns={
     *     @ORM\JoinColumn(name="dit_srv_clt_id", referencedColumnName="id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dit_srv_opt_id", referencedColumnName="id", onDelete="cascade")
     *   }
     * )
     */
    private $ditServiceOptions;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->srvCltDate       = new \DateTime();
        $this->ditServiceOptions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return bool
     */
    public function isSrvCltIsPayed()
    {
        return $this->srvCltIsPayed;
    }

    /**
     * @param bool $srvCltIsPayed
     */
    public function setSrvCltIsPayed($srvCltIsPayed)
    {
        $this->srvCltIsPayed = $srvCltIsPayed;
    }

    /**
     * @return string
     */
    public function getSrvCltPaymentType()
    {
        return $this->srvCltPaymentType;
    }

    /**
     * @param string $srvCltPaymentType
     */
    public function setSrvCltPaymentType($srvCltPaymentType)
    {
        $this->srvCltPaymentType = $srvCltPaymentType;
    }

    /**
     * @return bool
     */
    public function isSrvCltPaymentIsFacture()
    {
        return $this->srvCltPaymentIsFacture;
    }

    /**
     * @param bool $srvCltPaymentIsFacture
     */
    public function setSrvCltPaymentIsFacture($srvCltPaymentIsFacture)
    {
        $this->srvCltPaymentIsFacture = $srvCltPaymentIsFacture;
    }

    /**
     * @return string
     */
    public function getSrvCltProjectLink()
    {
        return $this->srvCltProjectLink;
    }

    /**
     * @param string $srvCltProjectLink
     */
    public function setSrvCltProjectLink($srvCltProjectLink)
    {
        $this->srvCltProjectLink = $srvCltProjectLink;
    }

    /**
     * @return \DateTime
     */
    public function getSrvCltDate()
    {
        return $this->srvCltDate;
    }

    /**
     * @param \DateTime $srvCltDate
     */
    public function setSrvCltDate($srvCltDate)
    {
        $this->srvCltDate = $srvCltDate;
    }

    /**
     * @return \DateTime
     */
    public function getSrvCltDateLivraisonPrev()
    {
        return $this->srvCltDateLivraisonPrev;
    }

    /**
     * @param \DateTime $srvCltDateLivraisonPrev
     */
    public function setSrvCltDateLivraisonPrev($srvCltDateLivraisonPrev)
    {
        $this->srvCltDateLivraisonPrev = $srvCltDateLivraisonPrev;
    }

    /**
     * @return \DateTime
     */
    public function getSrvCltDateLivraison()
    {
        return $this->srvCltDateLivraison;
    }

    /**
     * @param \DateTime $srvCltDateLivraison
     */
    public function setSrvCltDateLivraison($srvCltDateLivraison)
    {
        $this->srvCltDateLivraison = $srvCltDateLivraison;
    }

    /**
     * @return string
     */
    public function getSrvCltDesc()
    {
        return $this->srvCltDesc;
    }

    /**
     * @param string $srvCltDesc
     */
    public function setSrvCltDesc($srvCltDesc)
    {
        $this->srvCltDesc = $srvCltDesc;
    }

    /**
     * @return DitService
     */
    public function getDitService()
    {
        return $this->ditService;
    }

    /**
     * @param DitService $ditService
     */
    public function setDitService($ditService)
    {
        $this->ditService = $ditService;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDitServiceOptions()
    {
        return $this->ditServiceOptions;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $ditServiceOptions
     */
    public function setDitServiceOptions($ditServiceOptions)
    {
        $this->ditServiceOptions = $ditServiceOptions;
    }

    /**
     * Add $ditServiceOption
     *
     * @param DitServiceOption $ditServiceOption
     *
     * @return DitServiceOption
     */
    public function addDitServiceOption(DitServiceOption $ditServiceOption)
    {
        $this->ditServiceOptions[] = $ditServiceOption;

        return $this;
    }

    /**
     * Remove $ditServiceOption
     *
     * @param DitServiceOption $ditServiceOption
     */
    public function removeAdminSpace(DitServiceOption $ditServiceOption)
    {
        $this->ditServiceOptions->removeElement($ditServiceOption);
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

    /**
     * @return float
     */
    public function getSrvCltPrix()
    {
        return $this->srvCltPrix;
    }

    /**
     * @param float $srvCltPrix
     */
    public function setSrvCltPrix($srvCltPrix)
    {
        $this->srvCltPrix = $srvCltPrix;
    }

    /**
     * @return int
     */
    public function getSrvCltNbrPage()
    {
        return $this->srvCltNbrPage;
    }

    /**
     * @param int $srvCltNbrPage
     */
    public function setSrvCltNbrPage($srvCltNbrPage)
    {
        $this->srvCltNbrPage = $srvCltNbrPage;
    }

    /**
     * @return string
     */
    public function getServiceValidationString()
    {
        $_date = ($this->srvCltDate)->format('d/m/Y H:i');

        return $this->getDitUser()->getUsrNomEntreprise() . ' - ' . $this->ditService->getSrvLabel()
            . ' (le ' . $_date . ' - ' . $this->getStatusValidationString() . ')';
    }

    /**
     * @return string
     */
    public function getServiceProjectString()
    {
        $_date = ($this->srvCltDate)->format('d/m/Y H:i');

        return $this->getDitUser()->getUsrNomEntreprise() . ' - ' . $this->ditService->getSrvLabel()
            . ' (le ' . $_date . ' - ' . $this->getStatusProjectString() . ')';
    }

    /**
     * @return string
     */
    public function getStatusValidationString()
    {
        return EtatServiceValidation::$VALEUR_TYPE[$this->srvCltStatusValidation];
    }

    /**
     * @return string
     */
    public function getStatusProjectString()
    {
        return EtatServiceProject::$VALEUR_TYPE[$this->srvCltStatusProject];
    }

    /**
     * @return string
     */
    public function getFactureString()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSrvCltStatusValidation()
    {
        return $this->srvCltStatusValidation;
    }

    /**
     * @param int $srvCltStatusValidation
     */
    public function setSrvCltStatusValidation($srvCltStatusValidation)
    {
        $this->srvCltStatusValidation = $srvCltStatusValidation;
    }

    /**
     * @return int
     */
    public function getSrvCltStatusProject()
    {
        return $this->srvCltStatusProject;
    }

    /**
     * @param int $srvCltStatusProject
     */
    public function setSrvCltStatusProject($srvCltStatusProject)
    {
        $this->srvCltStatusProject = $srvCltStatusProject;
    }

    /**
     * @return int
     */
    public function getSrvCltNbrPageDecline()
    {
        return $this->srvCltNbrPageDecline;
    }

    /**
     * @param int $srvCltNbrPageDecline
     */
    public function setSrvCltNbrPageDecline($srvCltNbrPageDecline)
    {
        $this->srvCltNbrPageDecline = $srvCltNbrPageDecline;
    }

    /**
     * @return string
     */
    public function getSrvCltLienCodeSource()
    {
        return $this->srvCltLienCodeSource;
    }

    /**
     * @param string $srvCltLienCodeSource
     */
    public function setSrvCltLienCodeSource($srvCltLienCodeSource)
    {
        $this->srvCltLienCodeSource = $srvCltLienCodeSource;
    }

    /**
     * @return string
     */
    public function getSrvCltLienLivre()
    {
        return $this->srvCltLienLivre;
    }

    /**
     * @param string $srvCltLienLivre
     */
    public function setSrvCltLienLivre($srvCltLienLivre)
    {
        $this->srvCltLienLivre = $srvCltLienLivre;
    }

    /**
     * @return string
     */
    public function getFactureUrl()
    {
        return PathName::UPLOAD_FACTURE . 'FACTURE_PAIEMENT_NUMERO_' . $this->id . '.pdf';
    }
}
