<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/17/19
 * Time: 12:38 AM
 */

namespace App\Tzevent\BackOffice\AdminBundle\Controller;


use App\Tzevent\Service\MetierManagerBundle\Entity\TzeOrganisateur;
use App\Tzevent\Service\MetierManagerBundle\Form\TzeOrganisateurType;
use App\Tzevent\Service\MetierManagerBundle\Utils\ServiceName;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TzeOrganisateurController extends Controller
{

    /**
     * @return \App\Tzevent\Service\MetierManagerBundle\Metier\TzeOrganisateur\ServiceMetierTzeOrganisateur|object
     */
    public function getManager()
    {
        return $this->get(ServiceName::SRV_METIER_ORGANISATEUR);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $_organisateur_list = $this->getManager()->getAllTzeOrganisateur();

//        dump($_organisateur_list ? $_organisateur_list : null);die();
        return $this->render('AdminBundle:TzeOrganisateur:index.html.twig',array(
            'organisateurs' => $_organisateur_list
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $_organisateur = new TzeOrganisateur();

        $_form = $this->createCreateForm($_organisateur);
        $_form->handleRequest($request);

        if ($_form->isSubmitted() && $_form->isValid()):
            $_image = $_form['orgImage']->getData();
            $this->getManager()->addOrganisateur($_organisateur,$_image);
            try {
                $this->getManager()->setFlash('successfull', 'Organisateur ajouté');
            } catch (\Exception $e) {
            }
            return $this->redirect($this->generateUrl('organisateur_index'));
        endif;

        return $this->render('AdminBundle:TzeOrganisateur:add.html.twig',array(
            'organisateur' => $_organisateur,
            'form' => $_form->createView()
        ));
    }

    /**
     * @param TzeOrganisateur $_organisateur
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(TzeOrganisateur $_organisateur)
    {
        $_part_form = $this->createEditForm($_organisateur);
        return $this->render('AdminBundle:TzeOrganisateur:edit.html.twig',array(
            'organisateurs' => $_organisateur,
            'part_form'    => $_part_form->createView()
        ));
    }

    /**
     * @param Request $_request
     * @param TzeOrganisateur $_organisateur
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(Request $_request ,TzeOrganisateur $_organisateur)
    {
        $_part_form = $this->createDeleteForm($_organisateur);
        $_part_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_part_form->isSubmitted() && $_part_form->isValid())):
            try {
                $this->getManager()->deleteTzeOrganisateur($_organisateur);
                $this->getManager()->setFlash('success','Organisateur deleted');
            } catch (OptimisticLockException $e) {
            } catch (ORMException $e) {
            }
        endif;

        return $this->redirectToRoute('organisateur_index');
    }

    /**
     * @param Request $_request
     * @param TzeOrganisateur $_organisateur
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateAction(Request $_request ,TzeOrganisateur $_organisateur)
    {
        $_part_form = $this->createEditForm($_organisateur);
        $_part_form->handleRequest($_request);

        if ($_part_form->isValid()):
            $_image = $_part_form['orgImage']->getData();
            $this->getManager()->updateOrganisateur($_organisateur,$_image);
            $this->getManager()->setFlash('success','Organisateur mise a jour');
            return $this->redirect($this->generateUrl('organisateur_index'));
        endif;

        return $this->render('AdminBundle:TzeOrganisateur:edit.html.twig',array(
            'organisateurs' => $_organisateur,
            'form'         => $_part_form->createView()
        ));
    }

    /**
     * @param Request $_request
     * @param TzeOrganisateur $_organisateur
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteGroupAction(Request $_request , TzeOrganisateur $_organisateur)
    {
        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids === null) {
                try {
                    $this->getManager()->setFlash('error', 'Veuillez sélectionner un élément à supprimer');
                } catch (\Exception $e) {
                }
                return $this->redirect($this->generateUrl('organisateur_index'));
            }
            $this->getManager()->deleteGroupTzeOrganisateur($_ids);
        }
        try {
            $this->getManager()->setFlash('success', 'Eléments sélectionnés supprimés');
        } catch (\Exception $e) {
        }

        return $this->redirect($this->generateUrl('organisateur_index'));

    }

    /**
     * @param $_organisateur
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createCreateForm($_organisateur)
    {
        $_form = $this->createForm(TzeOrganisateurType::class,$_organisateur,array(
            'action' => $this->generateUrl('organisateur_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * @param TzeOrganisateur $_organisateur
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createEditForm(TzeOrganisateur $_organisateur)
    {
        $_form  = $this->createForm(TzeOrganisateurType::class,$_organisateur,array(
            'action' => $this->generateUrl('organisateur_update',array('id'=>$_organisateur->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * @param TzeOrganisateur $_organisateur
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createDeleteForm(TzeOrganisateur $_organisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('organisateur_delete',array('id'=>$_organisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}