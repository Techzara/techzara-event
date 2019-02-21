<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/17/19
 * Time: 12:10 AM
 */

namespace App\Shared\Repository;


use App\Shared\Entity\TzeOrganisateur;
use App\Shared\Services\Utils\EntityName;
use App\Shared\Services\Utils\PathName;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RepositoryTzeOrganisateurManager
{
    private $_entity_manager;
    private $_container;
    private $_web_root;

    /**
     * ServiceMetierTzeOrganisateur constructor.
     * @param EntityManager $_entity_manager
     * @param Container $_container
     * @param $_root_dir
     */
    public function __construct(EntityManager $_entity_manager, Container $_container, $_root_dir)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
        $this->_web_root       = realpath($_root_dir . '/../public');
    }

    /**
     * @param $_type
     * @param $_message
     * @return mixed
     * @throws \Exception
     */
    public function setFlash($_type, $_message) {
        return $this->_container->get('session')->getFlashBag()->add($_type, $_message);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::TZE_ORGANISATEUR);
    }

    /**
     * Récuperer tout les slides
     * @return array
     */
    public function getAllTzeOrganisateur()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les slides
     * @return array
     */
    public function getAllTzeOrganisateurOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Get activite ny event
     * @param $_event
     * @return mixed
     */
    public function getOrganisateurEvent($_event)
    {
        return $this->getRepository()->findByActEvent($_event);
    }

    /**
     * @param $_id
     * @return object|null
     */
    public function getTzeOrganisateurById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * @param TzeOrganisateur $_organisateur
     * @param $_action
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveTzeOrganisateur(TzeOrganisateur $_organisateur, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_organisateur);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * @param $_organisateur
     * @param $_image
     */
    public function addOrganisateur($_organisateur, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_organisateur);
            $this->addImage($_organisateur, $_image);
        }

        try {
            $this->saveTzeOrganisateur($_organisateur, 'new');
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
        }
    }

    /**
     * @param $_organisateur
     * @param $_image
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateOrganisateur($_organisateur, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_organisateur);
            $this->addImage($_organisateur, $_image);
        }

        $this->saveTzeOrganisateur($_organisateur, 'update');
    }

    /**
     * @param $_organisateur
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteTzeOrganisateur($_organisateur)
    {
        $this->deleteImage($_organisateur);

        $this->_entity_manager->remove($_organisateur);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * @param $_ids
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteGroupTzeOrganisateur($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_organisateur = $this->getTzeOrganisateurById($_id);
                $this->deleteTzeOrganisateur($_organisateur);
                $this->deleteImage($_organisateur);
            }
        }

        return true;
    }

    /**
     * @param $_organisateur
     * @param $_image
     */
    public function addImage(TzeOrganisateur $_organisateur, $_image) {
        // Récupérer le répertoire image spécifique
        $_directory_image  = PathName::UPLOAD_SLIDE;

        try {
            // Upload image
            $_file_name_image = md5(uniqid()) . '.' . $_image->guessExtension();
            $_uri_file        = $_directory_image . $_file_name_image;
            $_dir             = $this->_web_root . $_directory_image;
            $_image->move(
                $_dir,
                $_file_name_image
            );

            // Enregistrement image
            $_organisateur->setOrgImage($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }

    /**
     * Suppression image (fichier avec entité)
     * @param TzeOrganisateur $_organisateur
     * @return array
     */
    public function deleteImage(TzeOrganisateur $_organisateur)
    {
        if ($_organisateur) {
            try {
                $_path = $this->_web_root.$_organisateur->getOrgImage();

                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $this->_entity_manager->remove($_organisateur);
                $this->_entity_manager->flush();

                return array(
                    'success' => true
                );
            } catch (\Exception $_exc) {
                return array(
                    'success' => false,
                    'message' => $_exc->getTraceAsString()
                );
            }
        } else {
            return array(
                'success' => false,
                'message' => 'Image not found in database'
            );
        }
    }

    /**
     * @param TzeOrganisateur $_organisateur
     * @return bool
     */
    public function deleteOnlyImage(TzeOrganisateur $_organisateur)
    {
        if ($_organisateur) {
            $_path = $this->_web_root . $_organisateur->getOrgImage();

            // Suppression du fichier
            @unlink($_path);

            return true;
        }
    }
}