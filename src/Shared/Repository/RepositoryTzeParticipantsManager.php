<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/16/19
 * Time: 4:01 PM.
 */

namespace App\Shared\Repository;

use App\Shared\Entity\TzeParticipants;
use App\Shared\Services\Utils\EntityName;
use App\Shared\Services\Utils\PathName;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RepositoryTzeParticipantsManager
{
    private $_entity_manager;
    private $_container;
    private $_web_root;

    /**
     * ServiceMetierTzeParticipants constructor.
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
        return $this->_entity_manager->getRepository(EntityName::TZE_PARTICIPANTS);
    }

    /**
     * Récuperer tout les slides.
     *
     * @return array
     */
    public function getAllTzeParticipants()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les slides.
     *
     * @return array
     */
    public function getAllTzeParticipantsOrderAsc()
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
    public function getParticipantsEvent($_event)
    {
        return $this->getRepository()->findByActEvent($_event);
    }

    /**
     * @param $_id
     *
     * @return object|null
     */
    public function getTzeParticipantsById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * @param TzeParticipants $_participants
     * @param $_action
     *
     * @return bool
     */
    public function saveTzeParticipants(TzeParticipants $_participants, $_action)
    {
        if ('new' == $_action) {
            $this->_entity_manager->persist($_participants);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * @param $_participants
     * @param $_image
     */
    public function addParticipants($_participants, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_participants);
            $this->addImage($_participants, $_image);
        }

        try {
            $this->saveTzeParticipants($_participants, 'new');
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
        }
    }

    /**
     * @param $_participants
     * @param $_image
     */
    public function updateParticipants($_participants, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_participants);
            $this->addImage($_participants, $_image);
        }

        $this->saveTzeParticipants($_participants, 'update');
    }

    /**
     * @param $_participants
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteTzeParticipants($_participants)
    {
        $this->deleteImage($_participants);

        $this->_entity_manager->remove($_participants);
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
    public function deleteGroupTzeParticipants($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_participants = $this->getTzeParticipantsById($_id);
                $this->deleteTzeParticipants($_participants);
                $this->deleteImage($_participants);
            }
        }

        return true;
    }

    /**
     * @param $_participants
     * @param $_image
     */
    public function addImage(TzeParticipants $_participants, $_image)
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
            $_participants->setPartImage($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }

    /**
     * Suppression image (fichier avec entité).
     *
     * @param TzeParticipants $_participants
     *
     * @return array
     */
    public function deleteImage(TzeParticipants $_participants)
    {
        if ($_participants) {
            try {
                $_path = $this->_web_root.$_participants->getPartImage();

                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $this->_entity_manager->remove($_participants);
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
     * @param TzeParticipants $_participants
     *
     * @return array
     */
    public function deleteOnlyImage(TzeParticipants $_participants)
    {
        if ($_participants) {
            $_path = $this->_web_root.$_participants->getPartImage();

            // Suppression du fichier
            @unlink($_path);

            return true;
        }
    }
}
