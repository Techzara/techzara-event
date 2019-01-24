<?php

namespace App\Devintech\BackOffice\AdminBundle\Controller;

use App\Devintech\Service\MetierManagerBundle\Form\DitFactureType;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Devintech\Service\MetierManagerBundle\Entity\DitFacture;

/**
 * Class DitFactureController
 */
class DitFactureController extends Controller
{
    /**
     * Afficher tout les factures
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        // Récupérer tout les facture
        $_factures = $_facture_manager->getAllDitFacture();

        return $this->render('AdminBundle:DitFacture:index.html.twig', array(
            'factures' => $_factures
        ));
    }

    /**
     * Affichage page modification facture
     * @param DitFacture $_facture
     * @return Render page
     */
    public function editAction(DitFacture $_facture)
    {
        if (!$_facture) {
            throw $this->createNotFoundException('Unable to find DitFacture entity.');
        }

        $_edit_form = $this->createEditForm($_facture);

        return $this->render('AdminBundle:DitFacture:edit.html.twig', array(
            'facture'   => $_facture,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création facture
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        $_facture = new DitFacture();
        $_form    = $this->createCreateForm($_facture);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement facture
            $_facture_manager->saveDitFacture($_facture, 'new');

            $_facture_manager->setFlash('success', "Facture ajouté");

            return $this->redirect($this->generateUrl('facture_index'));
        }

        return $this->render('AdminBundle:DitFacture:add.html.twig', array(
            'facture' => $_facture,
            'form'    => $_form->createView(),
        ));
    }

    /**
     * Modification facture
     * @param Request $_request requête
     * @param DitFacture $_facture
     * @return Render page
     */
    public function updateAction(Request $_request, DitFacture $_facture)
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        if (!$_facture) {
            throw $this->createNotFoundException('Unable to find DitFacture entity.');
        }

        $_edit_form = $this->createEditForm($_facture);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_facture_manager->saveDitFacture($_facture, 'update');

            $_facture_manager->setFlash('success', "Facture modifié");

            return $this->redirect($this->generateUrl('facture_index'));
        }

        return $this->render('AdminBundle:DitFacture:edit.html.twig', array(
            'facture'   => $_facture,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition facture
     * @param DitFacture $_facture The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DitFacture $_facture)
    {
        $_form = $this->createForm(DitFactureType::class, $_facture, array(
            'action' => $this->generateUrl('facture_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création facture
     * @param DitFacture $_facture The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DitFacture $_facture)
    {
        $_form = $this->createForm(DitFactureType::class, $_facture, array(
            'action' => $this->generateUrl('facture_update', array('id' => $_facture->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression facture
     * @param Request $_request requête
     * @param DitFacture $_facture
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DitFacture $_facture)
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        $_form = $this->createDeleteForm($_facture);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression facture
            $_facture_manager->deleteDitFacture($_facture);

            $_facture_manager->setFlash('success', 'Facture supprimé');
        }

        return $this->redirectToRoute('facture_index');
    }

    /**
     * Création formulaire de suppression facture
     * @param DitFacture $_facture The DitFacture entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DitFacture $_facture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facture_delete', array('id' => $_facture->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste facture
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_facture_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('facture_index'));
            }
            $_facture_manager->deleteGroupDitFacture($_ids);
        }

        $_facture_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('facture_index'));
    }
}