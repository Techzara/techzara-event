<?php

namespace App\Devintech\BackOffice\AdminBundle\Controller;

use App\Devintech\Service\MetierManagerBundle\Form\DitServiceOptionTypeType;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Devintech\Service\MetierManagerBundle\Entity\DitServiceOptionType;

/**
 * Class DitServiceOptionTypeController
 */
class DitServiceOptionTypeController extends Controller
{
    /**
     * Afficher tout les service_option_types
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_service_option_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION_TYPE);

        // Récupérer tout les service_option_type
        $_service_option_types = $_service_option_type_manager->getAllDitServiceOptionType();

        return $this->render('AdminBundle:DitServiceOptionType:index.html.twig', array(
            'service_option_types' => $_service_option_types
        ));
    }

    /**
     * Affichage page modification service_option_type
     * @param DitServiceOptionType $_service_option_type
     * @return Render page
     */
    public function editAction(DitServiceOptionType $_service_option_type)
    {
        if (!$_service_option_type) {
            throw $this->createNotFoundException('Unable to find DitServiceOptionType entity.');
        }

        $_edit_form = $this->createEditForm($_service_option_type);

        return $this->render('AdminBundle:DitServiceOptionType:edit.html.twig', array(
            'service_option_type' => $_service_option_type,
            'edit_form'           => $_edit_form->createView()
        ));
    }

    /**
     * Création service_option_type
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_service_option_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION_TYPE);

        $_service_option_type = new DitServiceOptionType();
        $_form                = $this->createCreateForm($_service_option_type);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement service_option_type
            $_service_option_type_manager->saveDitServiceOptionType($_service_option_type, 'new');

            $_service_option_type_manager->setFlash('success', "Type option service ajouté");

            return $this->redirect($this->generateUrl('service_option_type_index'));
        }

        return $this->render('AdminBundle:DitServiceOptionType:add.html.twig', array(
            'service_option_type' => $_service_option_type,
            'form'                => $_form->createView()
        ));
    }

    /**
     * Modification service_option_type
     * @param Request $_request requête
     * @param DitServiceOptionType $_service_option_type
     * @return Render page
     */
    public function updateAction(Request $_request, DitServiceOptionType $_service_option_type)
    {
        // Récupérer manager
        $_service_option_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION_TYPE);

        if (!$_service_option_type) {
            throw $this->createNotFoundException('Unable to find DitServiceOptionType entity.');
        }

        $_edit_form = $this->createEditForm($_service_option_type);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_service_option_type_manager->saveDitServiceOptionType($_service_option_type, 'update');

            $_service_option_type_manager->setFlash('success', "Service modifié");

            return $this->redirect($this->generateUrl('service_option_type_index'));
        }

        return $this->render('AdminBundle:DitServiceOptionType:edit.html.twig', array(
            'service_option_type' => $_service_option_type,
            'edit_form'           => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition service_option_type
     * @param DitServiceOptionType $_service_option_type The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DitServiceOptionType $_service_option_type)
    {
        $_form = $this->createForm(DitServiceOptionTypeType::class, $_service_option_type, array(
            'action' => $this->generateUrl('service_option_type_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création service_option_type
     * @param DitServiceOptionType $_service_option_type The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DitServiceOptionType $_service_option_type)
    {
        $_form = $this->createForm(DitServiceOptionTypeType::class, $_service_option_type, array(
            'action' => $this->generateUrl('service_option_type_update', array('id' => $_service_option_type->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression service_option_type
     * @param Request $_request requête
     * @param DitServiceOptionType $_service_option_type
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DitServiceOptionType $_service_option_type)
    {
        // Récupérer manager
        $_service_option_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION_TYPE);

        $_form = $this->createDeleteForm($_service_option_type);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression service_option_type
            $_service_option_type_manager->deleteDitServiceOptionType($_service_option_type);

            $_service_option_type_manager->setFlash('success', 'Type option service supprimé');
        }

        return $this->redirectToRoute('service_option_type_index');
    }

    /**
     * Création formulaire de suppression service_option_type
     * @param DitServiceOptionType $_service_option_type The DitServiceOptionType entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DitServiceOptionType $_service_option_type)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_option_type_delete', array('id' => $_service_option_type->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste service_option_type
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_service_option_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION_TYPE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_service_option_type_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('service_option_type_index'));
            }
            $_service_option_type_manager->deleteGroupDitServiceOptionType($_ids);
        }

        $_service_option_type_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('service_option_type_index'));
    }
}