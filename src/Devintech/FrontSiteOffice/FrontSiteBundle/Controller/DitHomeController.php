<?php

namespace App\Devintech\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Devintech\Service\MetierManagerBundle\Utils\CmsName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;

/**
 * Class DitHomeController
 */
class DitHomeController extends Controller
{
    /**
     * Afficher la page accueil
     * @return string
     */
    public function indexAction()
    {
        // Récupérer manager
        $_slide_manager          = $this->get(ServiceName::SRV_METIER_SLIDE);
        $_slides          = $_slide_manager->getAllDitSlide();

        return $this->render('FrontSiteBundle:DitHome:index.html.twig', array(
            'slides'          => $_slides,
        ));
    }
}
