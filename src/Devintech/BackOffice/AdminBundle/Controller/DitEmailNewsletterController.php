<?php

namespace App\Devintech\BackOffice\AdminBundle\Controller;

use App\Devintech\Service\MetierManagerBundle\Entity\DitEmailNewsletter;
use App\Devintech\Service\MetierManagerBundle\Form\DitEmailNewsletterType;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DitEmailNewsletterController
 */
class DitEmailNewsletterController extends Controller
{
    /**
     * Afficher tout les emails
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_email_manager = $this->get(ServiceName::SRV_METIER_EMAIL_NEWSLETTER);

        // Récupérer tout les emails
        $_emails = $_email_manager->getAllEmailNewsletter();

        return $this->render('AdminBundle:DitEmailNewsletter:index.html.twig', array(
            'email_newsletters' => $_emails
        ));
    }

    /**
     * Affichage page modification email
     * @param DitEmailNewsletter $_email
     * @return Render page
     */
    public function editAction(DitEmailNewsletter $_email)
    {
        if (!$_email) {
            throw $this->createNotFoundException('Unable to find DitEmailNewsletter entity.');
        }

        $_edit_form = $this->createEditForm($_email);

        return $this->render('AdminBundle:DitEmailNewsletter:edit.html.twig', array(
            'email_newsletter' => $_email,
            'edit_form'        => $_edit_form->createView()
        ));
    }

    /**
     * Création email
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_email_manager = $this->get(ServiceName::SRV_METIER_EMAIL_NEWSLETTER);

        $_email = new DitEmailNewsletter();
        $_form  = $this->createCreateForm($_email);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement email
            $_email_manager->saveEmailNewsletter($_email, 'new');

            $_email_manager->setFlash('success', "Email abonné ajouté");

            return $this->redirect($this->generateUrl('email_newsletter_index'));
        }

        return $this->render('AdminBundle:DitEmailNewsletter:add.html.twig', array(
            'email_newsletter' => $_email,
            'form'             => $_form->createView()
        ));
    }

    /**
     * Modification email
     * @param Request $_request requête
     * @param DitEmailNewsletter $_email
     * @return Render page
     */
    public function updateAction(Request $_request, DitEmailNewsletter $_email)
    {
        // Récupérer manager
        $_email_manager = $this->get(ServiceName::SRV_METIER_EMAIL_NEWSLETTER);

        if (!$_email) {
            throw $this->createNotFoundException('Unable to find DitEmailNewsletter entity.');
        }

        $_edit_form = $this->createEditForm($_email);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_email_manager->saveEmailNewsletter($_email, 'update');

            $_email_manager->setFlash('success', "Email abonné modifié");

            return $this->redirect($this->generateUrl('email_newsletter_index'));
        }

        return $this->render('AdminBundle:DitEmailNewsletter:edit.html.twig', array(
            'email_newsletter' => $_email,
            'edit_form'        => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition email
     * @param DitEmailNewsletter $_email The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DitEmailNewsletter $_email)
    {
        $_form = $this->createForm(DitEmailNewsletterType::class, $_email, array(
            'action' => $this->generateUrl('email_newsletter_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création email
     * @param DitEmailNewsletter $_email The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DitEmailNewsletter $_email)
    {
        $_form = $this->createForm(DitEmailNewsletterType::class, $_email, array(
            'action' => $this->generateUrl('email_newsletter_update', array('id' => $_email->getId())),
            'method' => 'PUT',
        ));

        return $_form;
    }

    /**
     * Suppression email
     * @param Request $_request requête
     * @param DitEmailNewsletter $_email
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DitEmailNewsletter $_email)
    {
        // Récupérer manager
        $_email_manager = $this->get(ServiceName::SRV_METIER_EMAIL_NEWSLETTER);

        $_form = $this->createDeleteForm($_email);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression email
            $_email_manager->deleteEmailNewsletter($_email);

            $_email_manager->setFlash('success', 'Email abonné supprimé');
        }

        return $this->redirectToRoute('email_newsletter_index');
    }

    /**
     * Création formulaire de suppression email
     * @param DitEmailNewsletter $_email The DitEmailNewsletter entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DitEmailNewsletter $_email)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('email_newsletter_delete', array('id' => $_email->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste email
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_email_manager = $this->get(ServiceName::SRV_METIER_EMAIL_NEWSLETTER);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_email_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('email_newsletter_index'));
            }
            $_email_manager->deleteGroupEmailNewsletter($_ids);
        }

        $_email_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('email_newsletter_index'));
    }
}
