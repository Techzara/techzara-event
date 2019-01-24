<?php

namespace App\Devintech\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DitServiceType
 *
 * @ORM\Table(name="dit_service_type")
 * @UniqueEntity(fields="srvTpLabel", message="Nom déjà pris")
 * @ORM\Entity
 */
class DitServiceType
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
     * @ORM\Column(name="srv_tp_label", type="string", length=45, nullable=true)
     */
    private $srvTpLabel;


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
    public function getSrvTpLabel()
    {
        return $this->srvTpLabel;
    }

    /**
     * @param string $srvTpLabel
     */
    public function setSrvTpLabel($srvTpLabel)
    {
        $this->srvTpLabel = $srvTpLabel;
    }
}
