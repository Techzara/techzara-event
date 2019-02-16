<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/16/19
 * Time: 9:18 PM
 */

namespace App\Tzevent\Service\MetierManagerBundle\Metier\TzePartenaires;


use App\Tzevent\Service\MetierManagerBundle\Entity\TzePartenaires;
use App\Tzevent\Service\MetierManagerBundle\Utils\EntityName;
use App\Tzevent\Service\MetierManagerBundle\Utils\PathName;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceMetierPartenaires
{
    private $_entity_manager;
    private $_container;
    private $_web_root;

    /**
     * ServiceMetierTzePartenaires constructor.
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
        return $this->_entity_manager->getRepository(EntityName::TZE_PARTENAIRES);
    }

    /**
     * Récuperer tout les slides
     * @return array
     */
    public function getAllTzePartenaires()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les slides
     * @return array
     */
    public function getAllTzePartenairesOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Get activite ny event
     * @param $_event
     * @return mixed
     */
    public function getPartenairesEvent($_event)
    {
        return $this->getRepository()->findByActEvent($_event);
    }

    /**
     * @param $_id
     * @return object|null
     */
    public function getTzePartenairesById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * @param TzePartenaires $_partenaires
     * @param $_action
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveTzePartenaires(TzePartenaires $_partenaires, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_partenaires);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * @param $_partenaires
     * @param $_image
     */
    public function addPartenaires($_partenaires, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_partenaires);
            $this->addImage($_partenaires, $_image);
        }

        try {
            $this->saveTzePartenaires($_partenaires, 'new');
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
        }
    }

    /**
     * @param $_partenaires
     * @param $_image
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updatePartenaires($_partenaires, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_partenaires);
            $this->addImage($_partenaires, $_image);
        }

        $this->saveTzePartenaires($_partenaires, 'update');
    }

    /**
     * @param TzePartenaires $_partenaires
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteTzePartenaires(TzePartenaires $_partenaires)
    {
        $this->deleteImage($_partenaires);

        $this->_entity_manager->remove($_partenaires);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * @param $_ids
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteGroupTzePartenaires($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_partenaires = $this->getTzePartenairesById($_id);
                $this->deleteTzePartenaires($_partenaires);
                $this->deleteImage($_partenaires);
            }
        }

        return true;
    }

    /**
     * @param $_partenaires
     * @param $_image
     */
    public function addImage(TzePartenaires $_partenaires, $_image) {
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
            $_partenaires->setParteImage($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }

    /**
     * Suppression image (fichier avec entité)
     * @param TzePartenaires $_partenaires
     * @return array
     */
    public function deleteImage(TzePartenaires $_partenaires)
    {
        if ($_partenaires) {
            try {
                $_path = $this->_web_root.$_partenaires->getParteImage();

                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $this->_entity_manager->remove($_partenaires);
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
     * @param TzePartenaires $_partenaires
     * @return bool
     */
    public function deleteOnlyImage(TzePartenaires $_partenaires)
    {
        if ($_partenaires) {
            $_path = $this->_web_root . $_partenaires->getParteImage();

            // Suppression du fichier
            @unlink($_path);

            return true;
        }
    }
}