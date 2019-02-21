<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/21/19
 * Time: 10:51 PM
 */

namespace App\Bundle\User\Controller;

use App\Shared\Services\Utils\RoleName;
use App\Shared\Services\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Bundle\User\Entity\User;
use App\Bundle\User\Form\UserType;

/**
 * Class UserController
 *
 * @package UserBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @return mixed
     */
    public function getUserConnected()
    {
        return $this->get('security.token_storage')->getToken()->getUser();
    }

    /**
     * @return mixed
     */
    public function getUserRole()
    {
        return $this->getUserConnected()->getTzeRole()->getId();
    }

    /**
     * @return \App\Bundle\User\Repository\UserManager|object
     */
    public function getUserMetier()
    {
        return $this->get(ServiceName::SRV_METIER_USER);
    }

    /**
     * @return \App\Bundle\User\Repository\UploadManager|object
     */
    public function getUserUpload()
    {
        return $this->get(ServiceName::SRV_METIER_USER_UPLOAD);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function indexAction()
    {
        $_user_manager = $this->getUserMetier();

        $_users = $_user_manager->getAllUser();

        return $this->render('UserBundle:User:index.html.twig', array(
            'users' => $_users,
        ));
    }

    /**
     * @param User $_user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(User $_user)
    {
        $_id_user = $this->getUserConnected()->getId();
        $_user_role = $this->getUserRole();

        if (!$_user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        if (($_user_role !== RoleName::ID_ROLE_ADMIN) && ($_user_role !== RoleName::ID_ROLE_SUPERADMIN)) {
            if ($_user->getId() !== $_id_user) {
                return $this->redirectToRoute('user_edit', array(
                    'id' => $_id_user
                ));
            }
        }

        $_etze_form = $this->createEditForm($_user);

        $_template = 'UserBundle:User:edit.html.twig';
        if ($_user_role === RoleName::ID_ROLE_MEMBER)
            $_template = 'UserBundle:User:etze_member.html.twig';

        return $this->render($_template, array(
            'user' => $_user,
            'etze_form' => $_etze_form->createView()
        ));
    }

    /**
     * @param Request $_request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function newAction(Request $_request)
    {
        $_user_manager = $this->getUserMetier();

        $_user = new User();
        $_form = $this->createCreateForm($_user);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            $_user_manager->addUser($_user, $_form);
            $_user_manager->setFlash('success', "Utilisateur ajouté");

            return $this->redirect($this->generateUrl('user_index'));
        }

        return $this->render('UserBundle:User:add.html.twig', array(
            'user' => $_user,
            'form' => $_form->createView()
        ));
    }

    /**
     * @param Request $_request
     * @param User $_user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateAction(Request $_request, User $_user)
    {
        $_user_manager = $this->getUserMetier();

        if (!$_user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $_etze_form = $this->createEditForm($_user);
        $_etze_form->handleRequest($_request);

        if ($_etze_form->isValid()) {
            // Mise à jour utilisateur
            $_user_manager->updateUser($_user, $_etze_form);

            $_user_manager->setFlash('success', 'Utilisateur modifié');

            return $this->redirect($this->generateUrl('user_index'));
        }

        return $this->render('UserBundle:User:edit.html.twig', array(
            'user' => $_user,
            'etze_form' => $_etze_form->createView()
        ));
    }

    /**
     * @param User $_user
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createCreateForm(User $_user)
    {
        $_user_role = $this->getUserRole();

        $_form = $this->createForm(UserType::class, $_user, array(
            'action' => $this->generateUrl('user_new'),
            'method' => 'POST',
            'user_role' => $_user_role
        ));

        return $_form;
    }

    /**
     * @param User $_user
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createEditForm(User $_user)
    {
        $_user_role = $this->getUserRole();

        $_form = $this->createForm(UserType::class, $_user, array(
            'action' => $this->generateUrl('user_update', array('id' => $_user->getId())),
            'method' => 'PUT',
            'user_role' => $_user_role
        ));

        return $_form;
    }

    /**
     * @param Request $_request
     * @param User $_user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(Request $_request, User $_user)
    {
        // Récupérer manager
        $_user_manager = $this->getUserMetier();

        $_form = $this->createDeleteForm($_user);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression utilisateur
            $_user_manager->deleteUser($_user);
            $_user_manager->setFlash('success', 'Utilisateur supprimé');
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @param User $_user
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(User $_user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $_user->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Ajax suppression fichier image utilisateur
     * @param Request $_request
     * @return JsonResponse
     */
    public function deleteImageAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_user_upload_manager = $this->getUserUpload();

        // Récuperation identifiant fichier
        $_data = $_request->request->all();
        $_id = $_data['id'];

        // Suppression fichier image
        $_response = $_user_upload_manager->deleteImageById($_id);

        return new JsonResponse($_response);
    }

    /**
     * @param Request $_request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_user_manager = $this->getUserMetier();

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids === null) {
                $_user_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('user_index'));
            }
            $_user_manager->deleteGroupUser($_ids);
        }

        $_user_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('user_index'));
    }

    /**
     * @param Request $_request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function resettingPasswordAction(Request $_request)
    {
        // Récupérer manager
        $_user_manager = $this->getUserMetier();

        if ($_request->isMethod('POST')) {
            // Récuperer les données formulaire
            $_post = $_request->request->all();
            $_user_email = $_post['user-email'];

            $_resetting_password = $_user_manager->resettingPassword($_user_email);

            $_status = 'success';
            $_message = 'Récupération mot de passe a été envoyée au mail';
            if (!$_resetting_password) {
                $_status = 'error';
                $_message = 'Utilisateur non identifié';
            }

            $_user_manager->setFlash($_status, $_message);

            return $this->redirect($this->generateUrl('tze_resetting_password'));
        }

        return $this->render('UserBundle:Security:resetting_password.html.twig');
    }
}
