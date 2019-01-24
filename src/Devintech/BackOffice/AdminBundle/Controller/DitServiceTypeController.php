<?php

namespace App\Devintech\BackOffice\AdminBundle\Controller;

use App\Devintech\Service\MetierManagerBundle\Form\DitServiceTypeType;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Devintech\Service\MetierManagerBundle\Entity\DitServiceType;

/**
 * Class DitServiceTypeController
 */
class DitServiceTypeController extends Controller
{
    /**
     * Afficher tout les service types
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        // Récupérer tout les service_type
        $_service_types = $_service_type_manager->getAllDitServiceType();

        return $this->render('AdminBundle:DitServiceType:index.html.twig', array(
            'service_types' => $_service_types
        ));
    }

    /**
     * Affichage page modification service type
     * @param DitServiceType $_service_type
     * @return Render page
     */
    public function editAction(DitServiceType $_service_type)
    {
        if (!$_service_type) {
            throw $this->createNotFoundException('Unable to find DitServiceType entity.');
        }

        $_edit_form = $this->createEditForm($_service_type);

        return $this->render('AdminBundle:DitServiceType:edit.html.twig', array(
            'service_type' => $_service_type,
            'edit_form'    => $_edit_form->createView()
        ));
    }

    /**
     * Création service type
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        $_service_type = new DitServiceType();
        $_form         = $this->createCreateForm($_service_type);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement service type
            $_service_type_manager->saveDitServiceType($_service_type, 'new');

            $_service_type_manager->setFlash('success', "Type service ajouté");

            return $this->redirect($this->generateUrl('service_type_index'));
        }

        return $this->render('AdminBundle:DitServiceType:add.html.twig', array(
            'service_type' => $_service_type,
            'form'         => $_form->createView()
        ));
    }

    /**
     * Modification service type
     * @param Request $_request requête
     * @param DitServiceType $_service_type
     * @return Render page
     */
    public function updateAction(Request $_request, DitServiceType $_service_type)
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        if (!$_service_type) {
            throw $this->createNotFoundException('Unable to find DitServiceType entity.');
        }

        $_edit_form = $this->createEditForm($_service_type);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_service_type_manager->saveDitServiceType($_service_type, 'update');

            $_service_type_manager->setFlash('success', "Type service modifié");

            return $this->redirect($this->generateUrl('service_type_index'));
        }

        return $this->render('AdminBundle:DitServiceType:edit.html.twig', array(
            'service_type' => $_service_type,
            'edit_form'    => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition service type
     * @param DitServiceType $_service_type The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DitServiceType $_service_type)
    {
        $_form = $this->createForm(DitServiceTypeType::class, $_service_type, array(
            'action' => $this->generateUrl('service_type_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création service type
     * @param DitServiceType $_service_type The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DitServiceType $_service_type)
    {
        $_form = $this->createForm(DitServiceTypeType::class, $_service_type, array(
            'action' => $this->generateUrl('service_type_update', array('id' => $_service_type->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression service type
     * @param Request $_request requête
     * @param DitServiceType $_service_type
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DitServiceType $_service_type)
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        $_form = $this->createDeleteForm($_service_type);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression service type
            $_service_type_manager->deleteDitServiceType($_service_type);

            $_service_type_manager->setFlash('success', 'Type service supprimé');
        }

        return $this->redirectToRoute('service_type_index');
    }

    /**
     * Création formulaire de suppression service type
     * @param DitServiceType $_service_type The DitServiceType entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DitServiceType $_service_type)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_type_delete', array('id' => $_service_type->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste service type
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_service_type_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('service_type_index'));
            }
            $_service_type_manager->deleteGroupDitServiceType($_ids);
        }

        $_service_type_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('service_type_index'));
    }
}