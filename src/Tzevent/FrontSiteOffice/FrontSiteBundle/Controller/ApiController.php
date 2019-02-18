<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 2/18/19
 * Time: 1:57 PM
 */

namespace App\Tzevent\FrontSiteOffice\FrontSiteBundle\Controller;


use App\Tzevent\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends Controller
{
    /**
     * @return \App\Tzevent\Service\MetierManagerBundle\Metier\TzeSlide\ServiceMetierTzeSlide|object
     */
    public function getSlideManager()
    {
        return $this->get(ServiceName::SRV_METIER_SLIDE);
    }

    /**
     * @return \App\Tzevent\Service\MetierManagerBundle\Metier\TzeParticipants\ServiceMertierTzeParticipants|object
     */
    public function getParticipantManager()
    {
        return $this->get(ServiceName::SRV_METIER_PARTICIPANTS);
    }

    /**
     * @return \App\Tzevent\Service\MetierManagerBundle\Metier\TzePartenaires\ServiceMetierPartenaires|object
     */
    public function getPartenaireManager()
    {
        return $this->get(ServiceName::SRV_METIER_PARTENAIRES);
    }

    /**
     * @return \App\Tzevent\Service\MetierManagerBundle\Metier\TzeOrganisateur\ServiceMetierTzeOrganisateur|object
     */
    public function getOrganisateurManager()
    {
        return $this->get(ServiceName::SRV_METIER_ORGANISATEUR);
    }

    /**
     * @return array
     */
    public function allEvent()
    {
        return $this->getSlideManager()->getAllTzeSlide();
    }

    /**
     * @return mixed
     */
    public function getNewEvent()
    {
        return $this->allEvent()[0];
    }

    /**
     * @param $_name
     * @param $_data
     * @return JsonResponse
     */
    public function response($_name , $_data)
    {
        $_list= new JsonResponse();
        $_list->setData(array($_name => $_data));
        $_list->setStatusCode(200);

        return $_list;
    }
    /**
     * Liste des participants d'un evenement
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function participantsAction()
    {
        $_new_event = $this->getNewEvent();
        $_participant_list = $this->getParticipantManager()->getParticipantsEvent($_new_event);

        $_participant_lists = [];
        foreach ($_participant_list as $key => $_participant)
        {
            $_participant_lists[$key]['id'] = $_participant->getId();
            $_participant_lists[$key]['evenement'] = $_participant->getActEvent()->getSldEventTitle();
            $_participant_lists[$key]['universite'] = $_participant->getPartUniversite();
            $_participant_lists[$key]['team'] = $_participant->getPartTeam();
            $_participant_lists[$key]['image'] = $_participant->getPartImage();
        }

        return $this->response('participant_list' , $_participant_lists);
    }

    /**
     * Liste des partenaires des evenements
     * @return JsonResponse
     */
    public function partenairesListAction()
    {
        $_new_event = $this->getNewEvent();
        $_partenaires_list = $this->getPartenaireManager()->getPartenairesEvent($_new_event);

        $_partenaires_lists = [];
        foreach ($_partenaires_list as $key => $_partenaire)
        {
            $_partenaires_lists[$key]['id'] = $_partenaire->getId();
            $_partenaires_lists[$key]['evenement'] = $_partenaire->getActEvent()->getSldEventTitle();
            $_partenaires_lists[$key]['societe'] = $_partenaire->getParteEntite();
            $_partenaires_lists[$key]['contribution'] = $_partenaire->getParteContribution();
            $_partenaires_lists[$key]['image'] = $_partenaire->getParteImage();
        }

        return $this->response('partenaires_list' ,$_partenaires_lists);
    }

    /**
     * Liste des organisateurs d'un evenement
     * @return JsonResponse
     */
    public function organisateurAction()
    {
        $_new_event = $this->getNewEvent();
        $_organisateur_list = $this->getOrganisateurManager()->getOrganisateurEvent($_new_event);

        $_organisateur_lists = [];
        foreach ($_organisateur_list as $key => $_organisateur)
        {
            $_organisateur_lists[$key]['id'] = $_organisateur->getId();
            $_organisateur_lists[$key]['evenement'] = $_organisateur->getActEvent()->getSldEventTitle();
            $_organisateur_lists[$key]['name'] = $_organisateur->getOrgName();
            $_organisateur_lists[$key]['description'] = $_organisateur->getOrgDecription();
            $_organisateur_lists[$key]['responsabilite'] = $_organisateur->getOrgResponsabilite();
            $_organisateur_lists[$key]['image'] = $_organisateur->getOrgImage();
        }

        return $this->response('partenaires_list' , $_organisateur_lists);
    }
}