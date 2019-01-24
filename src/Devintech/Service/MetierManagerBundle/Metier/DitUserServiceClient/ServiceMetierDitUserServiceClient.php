<?php

namespace App\Devintech\Service\MetierManagerBundle\Metier\DitUserServiceClient;

use App\Devintech\Service\MetierManagerBundle\Entity\DitUserServiceClient;
use App\Devintech\Service\MetierManagerBundle\Utils\EtatServiceProject;
use App\Devintech\Service\MetierManagerBundle\Utils\EtatServiceValidation;
use App\Devintech\Service\MetierManagerBundle\Utils\RoleName;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;
use Doctrine\ORM\EntityManager;
use App\Devintech\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDitUserServiceClient
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
     * Récuperer le repository user_service_client
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::DIT_USER_SERVICE_CLIENT);
    }

    /**
     * Récuperer tout les user_service_clients
     * @return array
     */
    public function getAllDitUserServiceClient()
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->_container->get('security.token_storage')->getToken()->getUser();
        $_id_user        = $_user_connected->getId();
        $_user_role      = $_user_connected->getDitRole()->getId();

        // Rôle intégrateur
        if ($_user_role == RoleName::ID_ROLE_INTEGRATEUR) {
            return $this->getAllDitUserServiceClientByUser($_id_user);
        }

        // Rôle testeur
        if ($_user_role == RoleName::ID_ROLE_TESTEUR) {
            return $this->getAllDitUserServiceClientByTester($_id_user);
        }

        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }


    /**
     * Récupérer les user_service_clients par utilisateur
     * @param integer $_id_user
     * @return array
     */
    public function getAllDitUserServiceClientByUser($_id_user)
    {
        $_entity = EntityName::DIT_USER_SERVICE_CLIENT;
        $_dql    = "SELECT usc FROM $_entity usc
                    LEFT JOIN usc.ditUsers usr
                    WHERE usr.id = :id_user";

        $_query = $this->_entity_manager->createQuery($_dql);
        $_query->setParameter('id_user', $_id_user);

        return $_query->getResult();
    }

    /**
     * Récupérer les user_service_clients par testeur
     * @param integer $_id_user
     * @return array
     */
    public function getAllDitUserServiceClientByTester($_id_user)
    {
        $_entity = EntityName::DIT_USER_SERVICE_CLIENT;
        $_dql    = "SELECT usc FROM $_entity usc
                    LEFT JOIN usc.ditTesters tst
                    WHERE tst.id = :id_user";

        $_query = $this->_entity_manager->createQuery($_dql);
        $_query->setParameter('id_user', $_id_user);

        return $_query->getResult();
    }

    /**
     * Récuperer tout les user_service_clients
     * @return array
     */
    public function getAllDitUserServiceClientOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Récuperer un user_service_client par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDitUserServiceClientById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un user_service_client
     * @param DitUserServiceClient $_user_service_client
     * @param string $_action
     * @return boolean
     */
    public function saveDitUserServiceClient($_user_service_client, $_action)
    {
        // Récupérer manager
        $_service_client_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Récupérer l'utilisateur connecté
        $_user_connected = $this->_container->get('security.token_storage')->getToken()->getUser();

        // Enregistrement administrateur
        $_user_service_client->setDitAdmin($_user_connected);

        // Mise à jour statut service client en encours
        $_service_client = $_user_service_client->getDitServiceClient();
        $_service_client_manager->setStatusProjectService($_service_client, EtatServiceProject::ID_ENCOURS);

        if ($_action == 'new') {
            $this->_entity_manager->persist($_user_service_client);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un user_service_client
     * @param DitUserServiceClient $_user_service_client
     * @return boolean
     */
    public function deleteDitUserServiceClient($_user_service_client)
    {
        // Récupérer manager
        $_service_client_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Mise à jour statut service client en attente
        $_service_client = $_user_service_client->getDitServiceClient();
        $_service_client_manager->setStatusProjectService($_service_client, EtatServiceProject::ID_EN_ATTENTE);

        $this->_entity_manager->remove($_user_service_client);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un user_service_client
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDitUserServiceClient($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_user_service_client = $this->getDitUserServiceClientById($_id);
                $this->deleteDitUserServiceClient($_user_service_client);
            }
        }

        return true;
    }

    /**
     * Tester si l'utilisateur est bien attribué
     * @param integer $_id_user_service_clien
     * @param integer $_id_user
     * @return boolean
     */
    public function isUserAttributed($_id_user_service_clien, $_id_user)
    {
        $_entity = EntityName::DIT_USER_SERVICE_CLIENT;
        $_dql    = "SELECT usc FROM $_entity usc
                    LEFT JOIN usc.ditTesters tst
                    LEFT JOIN usc.ditUsers usr
                    WHERE tst.id = :id_user
                    OR usr.id = :id_user";

        $_query = $this->_entity_manager->createQuery($_dql);
        $_query->setParameter('id_user', $_id_user);

        $_result = $_query->getResult();
        if (count($_result) == 0)
            return false;

        return true;
    }
}