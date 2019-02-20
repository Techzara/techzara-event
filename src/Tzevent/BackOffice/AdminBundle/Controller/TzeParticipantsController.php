<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/16/19
 * Time: 4:37 PM
 */

namespace App\Tzevent\BackOffice\AdminBundle\Controller;


use App\Tzevent\Service\MetierManagerBundle\Entity\TzeParticipants;
use App\Tzevent\Service\MetierManagerBundle\Form\TzeParticipantsType;
use App\Tzevent\Service\MetierManagerBundle\Utils\ServiceName;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TzeParticipantsController extends Controller
{

    /**
     * @return \App\Tzevent\Service\MetierManagerBundle\Metier\TzeParticipants\ServiceMertierTzeParticipants|object
     */
    public function getManager()
    {
        return $this->get(ServiceName::SRV_METIER_PARTICIPANTS);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $_participants_list = $this->getManager()->getAllTzeParticipants();

//        dump($_participants_list);die();
        return $this->render('AdminBundle:TzeParticipants:index.html.twig',array(
            'participants' => $_participants_list
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $_participants = new TzeParticipants();

        $_form = $this->createCreateForm($_participants);
        $_form->handleRequest($request);

        if ($_form->isSubmitted() && $_form->isValid()):
//            dump($_form);die();
            $_image = $_form['partImage']->getData();
//        dump($_participants,$_image);die();
            $this->getManager()->addParticipants($_participants,$_image);
            try {
                $this->getManager()->setFlash('successfull', 'Participants ajouté');
            } catch (\Exception $e) {
            }
            return $this->redirect($this->generateUrl('participants_index'));
        endif;

        return $this->render('AdminBundle:TzeParticipants:add.html.twig',array(
            'participants' => $_participants,
            'form' => $_form->createView()
        ));
    }

    /**
     * @param TzeParticipants $_participants
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(TzeParticipants $_participants)
    {
        $_part_form = $this->createEditForm($_participants);
        return $this->render('AdminBundle:TzeParticipants:edit.html.twig',array(
            'participants' => $_participants,
            'part_form'    => $_part_form->createView()
        ));
    }

    /**
     * @param Request $_request
     * @param TzeParticipants $_participants
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(Request $_request ,TzeParticipants $_participants)
    {
        $_part_form = $this->createDeleteForm($_participants);
        $_part_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_part_form->isSubmitted() && $_part_form->isValid())):
            try {
                $this->getManager()->deleteTzeParticipants($_participants);
                $this->getManager()->setFlash('success','Participants deleted');
            } catch (OptimisticLockException $e) {
            } catch (ORMException $e) {
            }
        endif;

        return $this->redirectToRoute('participants_index');
    }

    /**
     * @param Request $_request
     * @param TzeParticipants $_participants
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateAction(Request $_request ,TzeParticipants $_participants)
    {
        $_part_form = $this->createEditForm($_participants);
        $_part_form->handleRequest($_request);

        if ($_part_form->isValid()):
            $_image = $_part_form['partImage']->getData();
            $this->getManager()->updateParticipants($_participants,$_image);
            $this->getManager()->setFlash('success','Participants mise a jour');
            return $this->redirect($this->generateUrl('participants_index'));
        endif;

        return $this->render('AdminBundle:TzeParticipants:edit.html.twig',array(
            'participants' => $_participants,
            'form'         => $_part_form->createView()
        ));
    }

    /**
     * @param Request $_request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteGroupAction(Request $_request)
    {
        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids === null) {
                $this->getManager()->setFlash('error', 'Veuillez sélectionner un élément à supprimer');
                return $this->redirect($this->generateUrl('participants_index'));
            }
            $this->getManager()->deleteGroupTzeParticipants($_ids);
        }
        $this->getManager()->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('participants_index'));
    }

    /**
     * @param $_participants
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createCreateForm($_participants)
    {
        $_form = $this->createForm(TzeParticipantsType::class,$_participants,array(
            'action' => $this->generateUrl('participants_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * @param TzeParticipants $_participants
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createEditForm(TzeParticipants $_participants)
    {
        $_form  = $this->createForm(TzeParticipantsType::class,$_participants,array(
            'action' => $this->generateUrl('participants_update',array('id'=>$_participants->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * @param TzeParticipants $_participants
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createDeleteForm(TzeParticipants $_participants)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('participants_delete',array('id'=>$_participants->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}