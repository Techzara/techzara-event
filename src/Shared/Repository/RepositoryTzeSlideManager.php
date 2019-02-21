<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/21/19
 * Time: 10:51 PM
 */

namespace App\Shared\Repository;

use App\Shared\Entity\TzeSlide;
use App\Shared\Services\Utils\PathName;
use Doctrine\ORM\EntityManager;
use App\Shared\Services\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RepositoryTzeSlideManager
{
    private $_entity_manager;
    private $_container;
    private $_web_root;

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
        return $this->_entity_manager->getRepository(EntityName::TZE_SLIDE);
    }

    /**
     * Récuperer tout les slides
     * @return array
     */
    public function getAllTzeSlide()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les slides
     * @return array
     */
    public function getAllTzeSlideOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * @param $_id
     * @return object|null
     */
    public function getTzeSlideById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * @param $_slide
     * @param $_action
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveTzeSlide($_slide, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_slide);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * @param $_slide
     * @param $_image
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addSlide($_slide, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_slide);
            $this->addImage($_slide, $_image);
        }

        $this->saveTzeSlide($_slide, 'new');
    }

    /**
     * @param $_slide
     * @param $_image
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateSlide($_slide, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_slide);
            $this->addImage($_slide, $_image);
        }

        $this->saveTzeSlide($_slide, 'update');
    }

    public function deleteTzeSlide( $_slide)
    {
        $this->deleteImage($_slide);
        $this->_entity_manager->remove($_slide);
        $this->_entity_manager->flush();

            return true;
    }

    /**
     * @param $_ids
     * @return bool
     */
    public function deleteGroupTzeSlide($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_slide = $this->getTzeSlideById($_id);
                $this->deleteTzeSlide($_slide);
                $this->deleteImage($_slide);
            }
        }

        return true;
    }

    /**
     * Ajout image
     * @param TzeSlide $_slide
     * @param object $_image
     */
    public function addImage($_slide, $_image) {
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
            $_slide->setSldImageUrl($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }

    /**
     * Suppression image (fichier avec entité)
     * @param TzeSlide $_slide
     * @return array
     */
    public function deleteImage($_slide)
    {
        if ($_slide) {
            try {
                $_path = $this->_web_root.$_slide->getSldImageUrl();

                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $this->_entity_manager->remove($_slide);
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
     * Suppression image (uniquement le fichier)
     * @param TzeSlide $_slide
     * @return array
     */
    public function deleteOnlyImage($_slide)
    {
        if ($_slide) {
            $_path = $this->_web_root . $_slide->getSldImageUrl();

            // Suppression du fichier
            @unlink($_path);

            return true;
        }
    }
}