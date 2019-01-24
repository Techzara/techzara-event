<?php

namespace App\Devintech\BackOffice\AdminBundle\Controller;

use App\Devintech\Service\MetierManagerBundle\Entity\DitMessageNewsletter;
use App\Devintech\Service\MetierManagerBundle\Form\DitMessageNewsletterType;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DitMessageNewsletterController
 */
class DitMessageNewsletterController extends Controller
{
    /**
     * Afficher tout les messages
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        // Récupérer tout les messages
        $_messages = $_message_manager->getAllMessageNewsletter();

        return $this->render('AdminBundle:DitMessageNewsletter:index.html.twig', array(
            'message_newsletters' => $_messages
        ));
    }

    /**
     * Affichage page modification message
     * @param DitMessageNewsletter $_message
     * @return Render page
     */
    public function editAction(DitMessageNewsletter $_message)
    {
        if (!$_message) {
            throw $this->createNotFoundException('Unable to find DitMessageNewsletter entity.');
        }

        $_edit_form = $this->createEditForm($_message);

        return $this->render('AdminBundle:DitMessageNewsletter:edit.html.twig', array(
            'message_newsletter'       => $_message,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création message
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        $_message = new DitMessageNewsletter();
        $_form    = $this->createCreateForm($_message);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement message
            $_message_manager->saveMessageNewsletter($_message, 'new');

            $_message_manager->setFlash('success', "Contenu newsletter ajouté");

            return $this->redirect($this->generateUrl('message_newsletter_index'));
        }

        return $this->render('AdminBundle:DitMessageNewsletter:add.html.twig', array(
            'message_newsletter' => $_message,
            'form'               => $_form->createView()
        ));
    }

    /**
     * Modification message
     * @param Request $_request requête
     * @param DitMessageNewsletter $_message
     * @return Render page
     */
    public function updateAction(Request $_request, DitMessageNewsletter $_message)
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        if (!$_message) {
            throw $this->createNotFoundException('Unable to find DitMessageNewsletter entity.');
        }

        $_edit_form = $this->createEditForm($_message);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_message_manager->saveMessageNewsletter($_message, 'update');

            $_message_manager->setFlash('success', "Contenu newsletter modifié");

            return $this->redirect($this->generateUrl('message_newsletter_index'));
        }

        return $this->render('AdminBundle:DitMessageNewsletter:edit.html.twig', array(
            'message_newsletter' => $_message,
            'edit_form'          => $_edit_form->createView()
        ));
    }

    /**
     * Modification message et envoi email
     * @param Request $_request requête
     * @param DitMessageNewsletter $_message
     * @return Render page
     */
    public function sendUpdateAction(Request $_request, DitMessageNewsletter $_message)
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        // Récupérer manager Email Newsletter
        $_email_manager = $this->get(ServiceName::SRV_METIER_EMAIL_NEWSLETTER);

        $_emails = $_email_manager->getAllEmailNewsletter();

        if (!$_message) {
            throw $this->createNotFoundException('Unable to find DitMessageNewsletter entity.');
        }

        $_edit_form = $this->createEditForm($_message);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_message_manager->sendEmailNewsletter($_request, $_emails);

            $_message_manager->saveMessageNewsletter($_message, 'update');

            $_message_manager->setFlash('success', "Mail newsletter envoyé avec succès");

            return $this->redirect($this->generateUrl('message_newsletter_index'));
        }

        return $this->render('AdminBundle:DitMessageNewsletter:edit.html.twig', array(
            'message_newsletter' => $_message,
            'edit_form'          => $_edit_form->createView()
        ));

    }

    /**
     * Création formulaire d'édition message
     * @param DitMessageNewsletter $_message The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DitMessageNewsletter $_message)
    {
        $_form = $this->createForm(DitMessageNewsletterType::class, $_message, array(
            'action' => $this->generateUrl('message_newsletter_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création message
     * @param DitMessageNewsletter $_message The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DitMessageNewsletter $_message)
    {
        $_form = $this->createForm(DitMessageNewsletterType::class, $_message, array(
            'action' => $this->generateUrl('message_newsletter_update', array('id' => $_message->getId())),
            'method' => 'PUT',
        ));

        return $_form;
    }

    /**
     * Création formulaire d'envoi message
     * @param DitMessageNewsletter $_message The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSendEditForm(DitMessageNewsletter $_message)
    {

        $_form = $this->createForm(DitMessageNewsletterType::class, $_message, array(
            'action' => $this->generateUrl('message_newsletter_sendupdate', array('id' => $_message->getId())),
            'method' => 'PUT',
        ));

        return $_form;
    }

    /**
     * Suppression message
     * @param Request $_request requête
     * @param DitMessageNewsletter $_message
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DitMessageNewsletter $_message)
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        $_form = $this->createDeleteForm($_message);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression message
            $_message_manager->deleteMessageNewsletter($_message);

            $_message_manager->setFlash('success', 'Contenu newsletter supprimé');
        }

        return $this->redirectToRoute('message_newsletter_index');
    }

    /**
     * Création formulaire de suppression message
     * @param DitMessageNewsletter $_message The DitMessageNewsletter entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DitMessageNewsletter $_message)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('message_newsletter_delete', array('id' => $_message->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste message
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_message_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('message_newsletter_index'));
            }
            $_message_manager->deleteGroupMessageNewsletter($_ids);
        }

        $_message_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('message_newsletter_index'));
    }

    /**
     * Envois  de tous les messages
     * @param DitMessageNewsletter $_message
     * @return Redirect liste message
     */
    public function sendAction(DitMessageNewsletter $_message)
    {
        if (!$_message) {
            throw $this->createNotFoundException('Unable to find DitMessageNewsletter entity.');
        }

        $_edit_form = $this->createSendEditForm($_message);

        return $this->render('AdminBundle:DitMessageNewsletter:send.html.twig', array(
            'message_newsletter' => $_message,
            'edit_form'          => $_edit_form->createView()
        ));
    }
}
