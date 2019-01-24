<?php

namespace App\Devintech\BackOffice\AdminBundle\Controller;

use App\Devintech\Service\MetierManagerBundle\Form\DitSlideType;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Devintech\Service\MetierManagerBundle\Entity\DitSlide;

/**
 * Class DitSlideController
 */
class DitSlideController extends Controller
{
    /**
     * Afficher tout les slides
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        // Récupérer tout les slide
        $_slides = $_slide_manager->getAllDitSlide();

        return $this->render('AdminBundle:DitSlide:index.html.twig', array(
            'slides' => $_slides
        ));
    }

    /**
     * Affichage page modification slide
     * @param DitSlide $_slide
     * @return Render page
     */
    public function editAction(DitSlide $_slide)
    {
        if (!$_slide) {
            throw $this->createNotFoundException('Unable to find DitSlide entity.');
        }

        $_edit_form = $this->createEditForm($_slide);

        return $this->render('AdminBundle:DitSlide:edit.html.twig', array(
            'slide'     => $_slide,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création slide
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        $_slide = new DitSlide();
        $_form  = $this->createCreateForm($_slide);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Traitement image
            $_image = $_form['sldImageUrl']->getData();

            // Enregistrement slide
            $_slide_manager->addSlide($_slide, $_image);

            $_slide_manager->setFlash('success', "Slide ajouté");

            return $this->redirect($this->generateUrl('slide_index'));
        }

        return $this->render('AdminBundle:DitSlide:add.html.twig', array(
            'slide' => $_slide,
            'form'  => $_form->createView(),
        ));
    }

    /**
     * Modification slide
     * @param Request $_request requête
     * @param DitSlide $_slide
     * @return Render page
     */
    public function updateAction(Request $_request, DitSlide $_slide)
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        if (!$_slide) {
            throw $this->createNotFoundException('Unable to find DitSlide entity.');
        }

        $_edit_form = $this->createEditForm($_slide);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            // Traitement image
            $_image = $_edit_form['sldImageUrl']->getData();

            // Enregistrement slide
            $_slide_manager->updateSlide($_slide, $_image);

            $_slide_manager->setFlash('success', "Slide modifié");

            return $this->redirect($this->generateUrl('slide_index'));
        }

        return $this->render('AdminBundle:DitSlide:edit.html.twig', array(
            'slide'     => $_slide,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition slide
     * @param DitSlide $_slide The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DitSlide $_slide)
    {
        $_form = $this->createForm(DitSlideType::class, $_slide, array(
            'action' => $this->generateUrl('slide_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création slide
     * @param DitSlide $_slide The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DitSlide $_slide)
    {
        $_form = $this->createForm(DitSlideType::class, $_slide, array(
            'action' => $this->generateUrl('slide_update', array('id' => $_slide->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression slide
     * @param Request $_request requête
     * @param DitSlide $_slide
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DitSlide $_slide)
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        $_form = $this->createDeleteForm($_slide);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression slide
            $_slide_manager->deleteDitSlide($_slide);

            $_slide_manager->setFlash('success', 'Slide supprimé');
        }

        return $this->redirectToRoute('slide_index');
    }

    /**
     * Création formulaire de suppression slide
     * @param DitSlide $_slide The DitSlide entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DitSlide $_slide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('slide_delete', array('id' => $_slide->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste slide
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_slide_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('slide_index'));
            }
            $_slide_manager->deleteGroupDitSlide($_ids);
        }

        $_slide_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('slide_index'));
    }
}