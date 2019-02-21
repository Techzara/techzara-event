<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/15/19
 * Time: 5:20 PM
 */

namespace App\Bundle\Admin\Controller;


use App\Shared\Entity\TzeEvenementActivite;
use App\Shared\Form\TzeActiviteType;
use App\Shared\Services\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TzeActiviteEvenement
 */
class TzeActiviteController extends Controller
{
    /**
     * @return \App\Shared\SharedBundle\Repository\TzeActiviteEvent\RepositoryTzeActiviteManager|object
     */
    public function getManager()
    {
        return $this->get(ServiceName::SRV_METIER_ACTIVITE);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $_activite_liste = $this->getManager()->getAllTzeActivite();

        return $this->render('AdminBundle:TzeActivite:index.html.twig',array(
            'activite' => $_activite_liste
        ));
    }


    /**
     * @param TzeEvenementActivite $_activite
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(TzeEvenementActivite $_activite)
    {
        if (!$_activite) {
            throw $this->createNotFoundException('Unable to find TzeEvenementActivite entity.');
        }

        $_etze_form = $this->createEditForm($_activite);

        return $this->render('AdminBundle:TzeActivite:edit.html.twig', array(
            'activite'     => $_activite,
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
        $_activite = new TzeEvenementActivite();
        $_form  = $this->createCreateForm($_activite);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {

            $_image = $_form['actImage']->getData();

            // Enregistrement slide
            $this->getManager()->addActivite($_activite, $_image);

            $this->getManager()->setFlash('success', 'Activite add successful');

            return $this->redirect($this->generateUrl('activite_index'));
        }


        return $this->render('AdminBundle:TzeActivite:add.html.twig', array(
            'activite' => $_activite,
            'form'  => $_form->createView(),
        ));
    }

    /**
     * @param Request $_request
     * @param TzeEvenementActivite $_activite
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateAction(Request $_request, TzeEvenementActivite $_activite)
    {

        if (!$_activite) {
            throw $this->createNotFoundException('Unable to find TzeSlide entity.');
        }

        $_etze_form = $this->createEditForm($_activite);
        $_etze_form->handleRequest($_request);

        if ($_etze_form->isValid()) {
            // Traitement image
            $_image = $_etze_form['actImage']->getData();

            // Enregistrement slide
            $this->getManager()->updateActivite($_activite, $_image);

            $this->getManager()->setFlash('success', "Slide modifié");

            return $this->redirect($this->generateUrl('activite_index'));
        }

        return $this->render('AdminBundle:TzeActivite:edit.html.twig', array(
            'activite'     => $_activite,
            'etze_form' => $_etze_form->createView()
        ));
    }

    /**
     * @param $_activite
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createCreateForm($_activite)
    {
        $_form = $this->createForm(TzeActiviteType::class, $_activite, array(
            'action' => $this->generateUrl('activite_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * @param TzeEvenementActivite $_activite
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createEditForm(TzeEvenementActivite $_activite)
    {
        $_form = $this->createForm(TzeActiviteType::class, $_activite, array(
            'action' => $this->generateUrl('activite_update', array('id' => $_activite->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * @param Request $_request
     * @param TzeEvenementActivite $_activite
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(Request $_request, TzeEvenementActivite $_activite)
    {
        $_form = $this->createDeleteForm($_activite);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression slide
            $this->getManager()->deleteTzeActivite($_activite);

            $this->getManager()->setFlash('success', 'activité supprimé');
        }

        return $this->redirectToRoute('activite_index');
    }

    /**
     * @param TzeEvenementActivite $_activite
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(TzeEvenementActivite $_activite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('activite_delete', array('id' => $_activite->getId())))
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
        $_activite_manager = $this->get(ServiceName::SRV_METIER_ACTIVITE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_activite_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('activite_index'));
            }
            $_activite_manager->deleteGroupTzeActivite($_ids);
        }

        $_activite_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('activite_index'));
    }
}