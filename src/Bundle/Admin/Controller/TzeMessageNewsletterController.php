<?php

namespace App\Bundle\Admin\Controller;

use App\Shared\Entity\TzeMessageNewsletter;
use App\Shared\Form\TzeMessageNewsletterType;
use App\Shared\Services\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TzeMessageNewsletterController.
 */
class TzeMessageNewsletterController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        // Récupérer tout les messages
        $_messages = $_message_manager->getAllMessageNewsletter();

        return $this->render('AdminBundle:TzeMessageNewsletter:index.html.twig', array(
            'message_newsletters' => $_messages,
        ));
    }

    /**
     * @param TzeMessageNewsletter $_message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(TzeMessageNewsletter $_message)
    {
        if (!$_message) {
            throw $this->createNotFoundException('Unable to find TzeMessageNewsletter entity.');
        }

        $_etze_form = $this->createEditForm($_message);

        return $this->render('AdminBundle:TzeMessageNewsletter:edit.html.twig', array(
            'message_newsletter' => $_message,
            'etze_form' => $_etze_form->createView(),
        ));
    }

    /**
     * @param Request $_request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        $_message = new TzeMessageNewsletter();
        $_form = $this->createCreateForm($_message);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement message
            $_message_manager->saveMessageNewsletter($_message, 'new');

            $_message_manager->setFlash('success', 'Contenu newsletter ajouté');

            return $this->redirect($this->generateUrl('message_newsletter_index'));
        }

        return $this->render('AdminBundle:TzeMessageNewsletter:add.html.twig', array(
            'message_newsletter' => $_message,
            'form' => $_form->createView(),
        ));
    }

    /**
     * @param Request $_request
     * @param TzeMessageNewsletter $_message
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateAction(Request $_request, TzeMessageNewsletter $_message)
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        if (!$_message) {
            throw $this->createNotFoundException('Unable to find TzeMessageNewsletter entity.');
        }

        $_etze_form = $this->createEditForm($_message);
        $_etze_form->handleRequest($_request);

        if ($_etze_form->isValid()) {
            $_message_manager->saveMessageNewsletter($_message, 'update');

            $_message_manager->setFlash('success', 'Contenu newsletter modifié');

            return $this->redirect($this->generateUrl('message_newsletter_index'));
        }

        return $this->render('AdminBundle:TzeMessageNewsletter:edit.html.twig', array(
            'message_newsletter' => $_message,
            'etze_form' => $_etze_form->createView(),
        ));
    }

    /**
     * @param Request $_request
     * @param TzeMessageNewsletter $_message
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function sendUpdateAction(Request $_request, TzeMessageNewsletter $_message)
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        // Récupérer manager Email Newsletter
        $_email_manager = $this->get(ServiceName::SRV_METIER_EMAIL_NEWSLETTER);

        $_emails = $_email_manager->getAllEmailNewsletter();

        if (!$_message) {
            throw $this->createNotFoundException('Unable to find TzeMessageNewsletter entity.');
        }

        $_etze_form = $this->createEditForm($_message);
        $_etze_form->handleRequest($_request);

        if ($_etze_form->isValid()) {
            $_message_manager->sendEmailNewsletter($_request, $_emails);

            $_message_manager->saveMessageNewsletter($_message, 'update');

            $_message_manager->setFlash('success', 'Mail newsletter envoyé avec succès');

            return $this->redirect($this->generateUrl('message_newsletter_index'));
        }

        return $this->render('AdminBundle:TzeMessageNewsletter:edit.html.twig', array(
            'message_newsletter' => $_message,
            'etze_form' => $_etze_form->createView(),
        ));
    }

    /**
     * @param TzeMessageNewsletter $_message
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createCreateForm(TzeMessageNewsletter $_message)
    {
        $_form = $this->createForm(TzeMessageNewsletterType::class, $_message, array(
            'action' => $this->generateUrl('message_newsletter_new'),
            'method' => 'POST',
        ));

        return $_form;
    }

    /**
     * @param TzeMessageNewsletter $_message
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createEditForm(TzeMessageNewsletter $_message)
    {
        $_form = $this->createForm(TzeMessageNewsletterType::class, $_message, array(
            'action' => $this->generateUrl('message_newsletter_update', array('id' => $_message->getId())),
            'method' => 'PUT',
        ));

        return $_form;
    }

    /**
     * @param TzeMessageNewsletter $_message
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createSendEditForm(TzeMessageNewsletter $_message)
    {
        $_form = $this->createForm(TzeMessageNewsletterType::class, $_message, array(
            'action' => $this->generateUrl('message_newsletter_sendupdate', array('id' => $_message->getId())),
            'method' => 'PUT',
        ));

        return $_form;
    }

    /**
     * @param Request $_request
     * @param TzeMessageNewsletter $_message
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction(Request $_request, TzeMessageNewsletter $_message)
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
     * @param TzeMessageNewsletter $_message
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(TzeMessageNewsletter $_message)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('message_newsletter_delete', array('id' => $_message->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * @param Request $_request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_message_manager = $this->get(ServiceName::SRV_METIER_MESSAGE_NEWSLETTER);

        if (null !== $_request->request->get('_group_delete')) {
            $_ids = $_request->request->get('delete');
            if (null == $_ids) {
                $_message_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('message_newsletter_index'));
            }
            $_message_manager->deleteGroupMessageNewsletter($_ids);
        }

        $_message_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('message_newsletter_index'));
    }

    /**
     * @param TzeMessageNewsletter $_message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendAction(TzeMessageNewsletter $_message)
    {
        if (!$_message) {
            throw $this->createNotFoundException('Unable to find TzeMessageNewsletter entity.');
        }

        $_etze_form = $this->createSendEditForm($_message);

        return $this->render('AdminBundle:TzeMessageNewsletter:send.html.twig', array(
            'message_newsletter' => $_message,
            'etze_form' => $_etze_form->createView(),
        ));
    }
}
