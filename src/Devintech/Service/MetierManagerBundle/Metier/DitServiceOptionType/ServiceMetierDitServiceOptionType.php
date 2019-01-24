<?php

namespace App\Devintech\Service\MetierManagerBundle\Metier\DitServiceOptionType;

use App\Devintech\Service\MetierManagerBundle\Entity\DitServiceOptionType;
use Doctrine\ORM\EntityManager;
use App\Devintech\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDitServiceOptionType
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
     * Récuperer le repository service_option_type
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::DIT_SERVICE_OPTION_TYPE);
    }

    /**
     * Récuperer tout les service_option_types
     * @return array
     */
    public function getAllDitServiceOptionType()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer un service_option_type par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDitServiceOptionTypeById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un service_option_type
     * @param DitServiceOptionType $_service_option_type
     * @param string $_action
     * @return boolean
     */
    public function saveDitServiceOptionType($_service_option_type, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_service_option_type);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un service_option_type
     * @param DitServiceOptionType $_service_option_type
     * @return boolean
     */
    public function deleteDitServiceOptionType($_service_option_type)
    {
        $this->_entity_manager->remove($_service_option_type);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un service_option_type
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDitServiceOptionType($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_service_option_type = $this->getDitServiceOptionTypeById($_id);
                $this->deleteDitServiceOptionType($_service_option_type);
            }
        }

        return true;
    }
}