<?php

namespace App\Devintech\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DitServiceOptionType
 *
 * @ORM\Table(name="dit_service_option_type")
 * @UniqueEntity(fields="srvOptTpLabel", message="Nom déjà pris")
 * @ORM\Entity
 */
class DitServiceOptionType
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
     * @ORM\Column(name="srv_opt_tp_label", type="string", length=45, nullable=true)
     */
    private $srvOptTpLabel;


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
    public function getSrvOptTpLabel()
    {
        return $this->srvOptTpLabel;
    }

    /**
     * @param string $srvOptTpLabel
     */
    public function setSrvOptTpLabel($srvOptTpLabel)
    {
        $this->srvOptTpLabel = $srvOptTpLabel;
    }
}
