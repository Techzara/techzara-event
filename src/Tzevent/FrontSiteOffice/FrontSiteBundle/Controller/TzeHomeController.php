<?php

namespace App\Tzevent\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Tzevent\Service\MetierManagerBundle\Entity\TzeEvenementActivite;
use App\Tzevent\Service\MetierManagerBundle\Utils\CmsName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Tzevent\Service\MetierManagerBundle\Utils\ServiceName;

/**
 * Class TzeHomeController
 */
class TzeHomeController extends Controller
{
    /**
     * Afficher la page accueil
     * @return string
     */
    public function indexAction()
    {
        //Récuperation manager
        $_slide_manager          = $this->get(ServiceName::SRV_METIER_SLIDE);
        $_event_manager          = $this->get(ServiceName::SRV_METIER_ACTIVITE);

        $_slides          = $_slide_manager->getAllTzeSlide();

        //Get new event
        $_slides_new[] = $_slides[0];

        //Get activite by evenement
        $_activite  = $_event_manager->getActiviteEvent($_slides[0]);

        $_evenement = [];
        foreach ($_slides as $key => $_event )
        {
            $_evenement[$key]['title'] = $_event->getSldEventTitle();
            $_evenement[$key]['description'] = $_event->getSldEventDescription();
            $_evenement[$key]['lieu'] = $_event->getSldLocation();
            $_evenement[$key]['participants'] = $_event->getSldPlace();
            $_evenement[$key]['date_debut'] = $_event->getSldDate();
            $_evenement[$key]['date_fin'] = $_event->getSldDateFin();
            $_evenement[$key]['intervenants'] = $_event->getSldIntervenant();
            $_evenement[$key]['image'] = $_event->getSldImageUrl();
        }


        return $this->render('FrontSiteBundle:TzeHome:index.html.twig', array(
            'slides'          => $_slides_new,
            'evenements'     => $_evenement,
            'activites'     => $_activite
        ));
    }
}
