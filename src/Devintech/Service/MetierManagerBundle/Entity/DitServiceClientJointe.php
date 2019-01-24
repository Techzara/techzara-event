<?php

namespace App\Devintech\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DitRole
 *
 * @ORM\Table(name="dit_service_client_jointe")
 * @ORM\Entity
 */
class DitServiceClientJointe
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
     * @ORM\Column(name="srv_clt_jt_ext", type="string", length=10, nullable=true)
     */
    private $srvCltJtExt;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_clt_jt_path", type="string", length=255, nullable=true)
     */
    private $srvCltJtPath;

    /**
     * @var DitServiceClient
     *
     * @ORM\ManyToOne(targetEntity="App\Devintech\Service\MetierManagerBundle\Entity\DitServiceClient", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dit_srv_clt_id", referencedColumnName="id", onDelete="CASCADE")
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
     * @return string
     */
    public function getSrvCltJtExt()
    {
        return $this->srvCltJtExt;
    }

    /**
     * @param string $srvCltJtExt
     */
    public function setSrvCltJtExt($srvCltJtExt)
    {
        $this->srvCltJtExt = $srvCltJtExt;
    }

    /**
     * @return string
     */
    public function getSrvCltJtPath()
    {
        return $this->srvCltJtPath;
    }

    /**
     * @param string $srvCltJtPath
     */
    public function setSrvCltJtPath($srvCltJtPath)
    {
        $this->srvCltJtPath = $srvCltJtPath;
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
}
