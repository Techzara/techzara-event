<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/16/19
 * Time: 9:42 PM
 */

namespace App\Tzevent\BackOffice\AdminBundle\Controller;


use App\Tzevent\Service\MetierManagerBundle\Entity\TzePartenaires;
use App\Tzevent\Service\MetierManagerBundle\Form\TzePartenairesType;
use App\Tzevent\Service\MetierManagerBundle\Utils\ServiceName;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TzePartenairesController
 * @package App\Tzevent\BackOffice\AdminBundle\Controller
 */
class TzePartenairesController extends  Controller
{

    /**
     * @return \App\Tzevent\Service\MetierManagerBundle\Metier\TzePartenaires\ServiceMetierPartenaires|object
     */
    public function getManager()
    {
        return $this->get(ServiceName::SRV_METIER_PARTENAIRES);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $_partenaires_list = $this->getManager()->getAllTzePartenaires();

//        dump($_partenaires_list ? $_partenaires_list : null);die();
        return $this->render('AdminBundle:TzePartenaires:index.html.twig',array(
            'partenaires' => $_partenaires_list
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $_partenaires = new TzePartenaires();

        $_form = $this->createCreateForm($_partenaires);
        $_form->handleRequest($request);

        if ($_form->isSubmitted() && $_form->isValid()):
            $_image = $_form['parteImage']->getData();
            $this->getManager()->addPartenaires($_partenaires,$_image);
            try {
                $this->getManager()->setFlash('successfull', 'Participants ajouté');
            } catch (\Exception $e) {
            }
            return $this->redirect($this->generateUrl('partenaires_index'));
        endif;

        return $this->render('AdminBundle:TzePartenaires:add.html.twig',array(
            'partenaires' => $_partenaires,
            'form' => $_form->createView()
        ));
    }

    /**
     * @param TzePartenaires $_partenaires
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(TzePartenaires $_partenaires)
    {
        $_part_form = $this->createEditForm($_partenaires);
        return $this->render('AdminBundle:TzePartenaires:edit.html.twig',array(
            'partenaires' => $_partenaires,
            'part_form'    => $_part_form->createView()
        ));
    }

    /**
     * @param Request $_request
     * @param TzePartenaires $_partenaires
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(Request $_request ,TzePartenaires $_partenaires)
    {
        $_part_form = $this->createDeleteForm($_partenaires);
        $_part_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_part_form->isSubmitted() && $_part_form->isValid())):
            try {
                $this->getManager()->deleteTzePartenaires($_partenaires);
                $this->getManager()->setFlash('success','Partenaires deleted');
            } catch (OptimisticLockException $e) {
            } catch (ORMException $e) {
            }
        endif;

        return $this->redirectToRoute('partenaires_index');
    }

    /**
     * @param Request $_request
     * @param TzePartenaires $_partenaires
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateAction(Request $_request ,TzePartenaires $_partenaires)
    {
        $_part_form = $this->createEditForm($_partenaires);
        $_part_form->handleRequest($_request);

        if ($_part_form->isValid()):
            $_image = $_part_form['parteImage']->getData();
            $this->getManager()->updatePartenaires($_partenaires,$_image);
            $this->getManager()->setFlash('success','Partenaires mise a jour');
            return $this->redirect($this->generateUrl('partenaires_index'));
        endif;

        return $this->render('AdminBundle:TzeParticipants:edit.html.twig',array(
            'partenaires' => $_partenaires,
            'form'         => $_part_form->createView()
        ));
    }

    /**
     * @param Request $_request
     * @param TzePartenaires $_partenaires
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteGroupAction(Request $_request , TzePartenaires $_partenaires)
    {
        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids === null) {
                try {
                    $this->getManager()->setFlash('error', 'Veuillez sélectionner un élément à supprimer');
                } catch (\Exception $e) {
                }
                return $this->redirect($this->generateUrl('partenaires_index'));
            }
            $this->getManager()->deleteGroupTzePartenaires($_ids);
        }
        try {
            $this->getManager()->setFlash('success', 'Eléments sélectionnés supprimés');
        } catch (\Exception $e) {
        }

        return $this->redirect($this->generateUrl('partenaires_index'));

    }

    /**
     * @param $_partenaires
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createCreateForm($_partenaires)
    {
        $_form = $this->createForm(TzePartenairesType::class,$_partenaires,array(
            'action' => $this->generateUrl('partenaires_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * @param TzePartenaires $_partenaires
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createEditForm(TzePartenaires $_partenaires)
    {
        $_form  = $this->createForm(TzePartenairesType::class,$_partenaires,array(
            'action' => $this->generateUrl('partenaires_update',array('id'=>$_partenaires->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * @param TzePartenaires $_partenaires
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createDeleteForm(TzePartenaires $_partenaires)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partenaires_delete',array('id'=>$_partenaires->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}