<?php

namespace App\Tzevent\FrontSiteOffice\FrontSiteBundle\Controller;

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
        // Récupérer manager
        $_slide_manager          = $this->get(ServiceName::SRV_METIER_SLIDE);
        $_slides          = $_slide_manager->getAllTzeSlide();

        return $this->render('FrontSiteBundle:TzeHome:index.html.twig', array(
            'slides'          => $_slides,
        ));
    }
}
