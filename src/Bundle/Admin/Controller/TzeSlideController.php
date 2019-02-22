<?php

namespace App\Bundle\Admin\Controller;

use App\Shared\Form\TzeSlideType;
use App\Shared\Services\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Shared\Entity\TzeSlide;

/**
 * Class TzeSlideController.
 */
class TzeSlideController extends Controller
{
    /**
     * @return \App\Shared\Repository\RepositoryTzeSlideManager|object
     */
    public function getManager()
    {
        return $this->get(ServiceName::SRV_METIER_SLIDE);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $_slides = $this->getManager()->getAllTzeSlide();

        return $this->render('AdminBundle:TzeSlide:index.html.twig', array(
            'slides' => $_slides,
        ));
    }

    /**
     * @param TzeSlide $_slide
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(TzeSlide $_slide)
    {
        if (!$_slide) {
            throw $this->createNotFoundException('Unable to find TzeSlide entity.');
        }

        $_etze_form = $this->createEditForm($_slide);

        return $this->render('AdminBundle:TzeSlide:edit.html.twig', array(
            'slide' => $_slide,
            'etze_form' => $_etze_form->createView(),
        ));
    }

    /**
     * @param Request $_request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function newAction(Request $_request)
    {
        $_slide = new TzeSlide();
        $_form = $this->createCreateForm($_slide);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Traitement image
            $_image = $_form['sldImageUrl']->getData();

            // Enregistrement slide
            $this->getManager()->addSlide($_slide, $_image);

            $this->getManager()->setFlash('success', 'Event add successful');

            return $this->redirect($this->generateUrl('slide_index'));
        }

        return $this->render('AdminBundle:TzeSlide:add.html.twig', array(
            'slide' => $_slide,
            'form' => $_form->createView(),
        ));
    }

    /**
     * @param Request  $_request
     * @param TzeSlide $_slide
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateAction(Request $_request, TzeSlide $_slide)
    {
        if (!$_slide) {
            throw $this->createNotFoundException('Unable to find TzeSlide entity.');
        }

        $_etze_form = $this->createEditForm($_slide);
        $_etze_form->handleRequest($_request);

        if ($_etze_form->isValid()) {
            // Traitement image
            $_image = $_etze_form['sldImageUrl']->getData();

            // Enregistrement slide
            $this->getManager()->updateSlide($_slide, $_image);

            $this->getManager()->setFlash('success', 'Slide modifié');

            return $this->redirect($this->generateUrl('slide_index'));
        }

        return $this->render('AdminBundle:TzeSlide:edit.html.twig', array(
            'slide' => $_slide,
            'etze_form' => $_etze_form->createView(),
        ));
    }

    /**
     * Création formulaire d'édition slide.
     *
     * @param TzeSlide $_slide The entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createCreateForm(TzeSlide $_slide)
    {
        $_form = $this->createForm(TzeSlideType::class, $_slide, array(
            'action' => $this->generateUrl('slide_new'),
            'method' => 'POST',
        ));

        return $_form;
    }

    /**
     * Création formulaire de création slide.
     *
     * @param TzeSlide $_slide The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TzeSlide $_slide)
    {
        $_form = $this->createForm(TzeSlideType::class, $_slide, array(
            'action' => $this->generateUrl('slide_update', array('id' => $_slide->getId())),
            'method' => 'PUT',
        ));

        return $_form;
    }

    /**
     * @param Request  $_request
     * @param TzeSlide $_slide
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \Exception
     */
    public function deleteAction(Request $_request, TzeSlide $_slide)
    {
        $_form = $this->createDeleteForm($_slide);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression slide
            $this->getManager()->deleteTzeSlide($_slide);

            $this->getManager()->setFlash('success', 'Slide supprimé');
        }

        return $this->redirectToRoute('slide_index');
    }

    /**
     * @param TzeSlide $_slide
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(TzeSlide $_slide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('slide_delete', array('id' => $_slide->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @param Request $_request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \Exception
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        if (null !== $_request->request->get('_group_delete')) {
            $_ids = $_request->request->get('delete');
            if (null == $_ids) {
                $_slide_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('slide_index'));
            }
            $_slide_manager->deleteGroupTzeSlide($_ids);
        }

        $_slide_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('slide_index'));
    }
}
