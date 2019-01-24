<?php

namespace App\Devintech\Service\MetierManagerBundle\Metier\DitRole;

use App\Devintech\Service\MetierManagerBundle\Entity\DitRole;
use Doctrine\ORM\EntityManager;
use App\Devintech\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDitRole
{
    private $_entity_manager;
    private $_container;

    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
    }

    /**
     * Ajouter un message flash
     * @param string $_type
     * @param string $_message
     * @return mixed
     */
    public function setFlash($_type, $_message) {
        return $this->_container->get('session')->getFlashBag()->add($_type, $_message);
    }

    /**
     * Récuperer le repository rôle
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::DIT_USER_ROLE);
    }

    /**
     * Récuperer tout les rôles
     * @return array
     */
    public function getAllDitRole()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Récuperer un rôle par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDitRoleById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un rôle
     * @param DitRole $_role
     * @param string $_action
     * @return boolean
     */
    public function saveDitRole($_role, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_role);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un rôle
     * @param DitRole $_role
     * @return boolean
     */
    public function deleteDitRole($_role)
    {
        $this->_entity_manager->remove($_role);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un rôle
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDitRole($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_role = $this->getDitRoleById($_id);
                $this->deleteDitRole($_role);
            }
        }

        return true;
    }
}