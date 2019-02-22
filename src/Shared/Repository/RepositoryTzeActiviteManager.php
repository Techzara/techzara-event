<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/15/19
 * Time: 5:05 PM.
 */

namespace App\Shared\Repository;

use App\Shared\Entity\TzeEvenementActivite;
use App\Shared\Services\Utils\EntityName;
use App\Shared\Services\Utils\PathName;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\Container;

class RepositoryTzeActiviteManager
{
    private $_entity_manager;
    private $_container;
    private $_web_root;

    /**
     * ServiceMetierTzeActivite constructor.
     *
     * @param EntityManager $_entity_manager
     * @param Container     $_container
     * @param $_root_dir
     */
    public function __construct(EntityManager $_entity_manager, Container $_container, $_root_dir)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container = $_container;
        $this->_web_root = realpath($_root_dir.'/../public');
    }

    /**
     * @param $_type
     * @param $_message
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function setFlash($_type, $_message)
    {
        return $this->_container->get('session')->getFlashBag()->add($_type, $_message);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::TZE_ACTIVITE);
    }

    /**
     * Récuperer tout les slides.
     *
     * @return array
     */
    public function getAllTzeActivite()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les slides.
     *
     * @return array
     */
    public function getAllTzeActiviteOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Get activite ny event.
     *
     * @param $_event
     *
     * @return mixed
     */
    public function getActiviteEvent($_event)
    {
        return $this->getRepository()->findByActEvent($_event);
    }

    /**
     * @param $_id
     *
     * @return object|null
     */
    public function getTzeActiviteById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * @param TzeEvenementActivite $_activite
     * @param $_action
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveTzeActivite(TzeEvenementActivite $_activite, $_action)
    {
        if ('new' == $_action) {
            $this->_entity_manager->persist($_activite);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * @param $_activite
     * @param $_image
     */
    public function addActivite($_activite, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_activite);
            $this->addImage($_activite, $_image);
        }

        try {
            $this->saveTzeActivite($_activite, 'new');
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
        }
    }

    /**
     * @param $_activite
     * @param $_image
     */
    public function updateActivite($_activite, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_activite);
            $this->addImage($_activite, $_image);
        }

        $this->saveTzeActivite($_activite, 'update');
    }

    /**
     * @param $_activite
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteTzeActivite($_activite)
    {
        $this->deleteImage($_activite);

        $this->_entity_manager->remove($_activite);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * @param $_ids
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteGroupTzeActivite($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_activite = $this->getTzeActiviteById($_id);
                $this->deleteTzeActivite($_activite);
                $this->deleteImage($_activite);
            }
        }

        return true;
    }

    /**
     * @param $_activite
     * @param $_image
     */
    public function addImage(TzeEvenementActivite $_activite, $_image)
    {
        // Récupérer le répertoire image spécifique
        $_directory_image = PathName::UPLOAD_SLIDE;

        try {
            // Upload image
            $_file_name_image = md5(uniqid()).'.'.$_image->guessExtension();
            $_uri_file = $_directory_image.$_file_name_image;
            $_dir = $this->_web_root.$_directory_image;
            $_image->move(
                $_dir,
                $_file_name_image
            );

            // Enregistrement image
            $_activite->setActImage($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }

    /**
     * Suppression image (fichier avec entité).
     *
     * @param TzeEvenementActivite $_activite
     *
     * @return array
     */
    public function deleteImage(TzeEvenementActivite $_activite)
    {
        if ($_activite) {
            try {
                $_path = $this->_web_root.$_activite->getActImage();

                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $this->_entity_manager->remove($_activite);
                $this->_entity_manager->flush();

                return array(
                    'success' => true,
                );
            } catch (\Exception $_exc) {
                return array(
                    'success' => false,
                    'message' => $_exc->getTraceAsString(),
                );
            }
        } else {
            return array(
                'success' => false,
                'message' => 'Image not found in database',
            );
        }
    }

    /**
     * Suppression image (uniquement le fichier).
     *
     * @param TzeEvenementActivite $_activite
     *
     * @return array
     */
    public function deleteOnlyImage(TzeEvenementActivite $_activite)
    {
        if ($_activite) {
            $_path = $this->_web_root.$_activite->getActImage();

            // Suppression du fichier
            @unlink($_path);

            return true;
        }
    }
}
