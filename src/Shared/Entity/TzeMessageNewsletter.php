<?php

namespace App\Shared\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * TzeMessageNewsletter
 *
 * @ORM\Table(name="tze_message_newsletter")
 * @ORM\Entity
 */
class TzeMessageNewsletter
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
