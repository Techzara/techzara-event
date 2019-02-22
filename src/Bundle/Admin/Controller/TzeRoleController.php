<?php

namespace App\Bundle\Admin\Controller;

use App\Shared\Form\TzeRoleType;
use App\Shared\Services\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Shared\Entity\TzeRole;

/**
 * Class TzeRoleController.
 */
class TzeRoleController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        // Récupérer tout les role
        $_roles = $_role_manager->getAllTzeRole();

        return $this->render('AdminBundle:TzeRole:index.html.twig', array(
            'roles' => $_roles,
        ));
    }

    /**
     * @param TzeRole $_role
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(TzeRole $_role)
    {
        if (!$_role) {
            throw $this->createNotFoundException('Unable to find TzeRole entity.');
        }

        $_etze_form = $this->createEditForm($_role);

        return $this->render('AdminBundle:TzeRole:edit.html.twig', array(
            'role' => $_role,
            'etze_form' => $_etze_form->createView(),
        ));
    }

    /**
     * @param Request $_request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        $_role = new TzeRole();
        $_form = $this->createCreateForm($_role);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement rôle
            $_role_manager->saveTzeRole($_role, 'new');

            $_role_manager->setFlash('success', 'Rôle ajouté');

            return $this->redirect($this->generateUrl('role_index'));
        }

        return $this->render('AdminBundle:TzeRole:add.html.twig', array(
            'role' => $_role,
            'form' => $_form->createView(),
        ));
    }

    /**
     * @param Request $_request
     * @param TzeRole $_role
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $_request, TzeRole $_role)
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        if (!$_role) {
            throw $this->createNotFoundException('Unable to find TzeRole entity.');
        }

        $_etze_form = $this->createEditForm($_role);
        $_etze_form->handleRequest($_request);

        if ($_etze_form->isValid()) {
            $_role_manager->saveTzeRole($_role, 'update');

            $_role_manager->setFlash('success', 'Rôle modifié');

            return $this->redirect($this->generateUrl('role_index'));
        }

        return $this->render('AdminBundle:TzeRole:edit.html.twig', array(
            'role' => $_role,
            'etze_form' => $_etze_form->createView(),
        ));
    }

    /**
     * @param TzeRole $_role
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createCreateForm(TzeRole $_role)
    {
        $_form = $this->createForm(TzeRoleType::class, $_role, array(
            'action' => $this->generateUrl('role_new'),
            'method' => 'POST',
        ));

        return $_form;
    }

    /**
     * @param TzeRole $_role
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createEditForm(TzeRole $_role)
    {
        $_form = $this->createForm(TzeRoleType::class, $_role, array(
            'action' => $this->generateUrl('role_update', array('id' => $_role->getId())),
            'method' => 'PUT',
        ));

        return $_form;
    }

    /**
     * @param Request $_request
     * @param TzeRole $_role
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $_request, TzeRole $_role)
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        $_form = $this->createDeleteForm($_role);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression rôle
            $_role_manager->deleteTzeRole($_role);

            $_role_manager->setFlash('success', 'Rôle supprimé');
        }

        return $this->redirectToRoute('role_index');
    }

    /**
     * @param TzeRole $_role
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(TzeRole $_role)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('role_delete', array('id' => $_role->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @param Request $_request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        if (null !== $_request->request->get('_group_delete')) {
            $_ids = $_request->request->get('delete');
            if (null == $_ids) {
                $_role_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('role_index'));
            }
            $_role_manager->deleteGroupTzeRole($_ids);
        }

        $_role_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('role_index'));
    }
}
