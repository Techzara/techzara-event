<?php

namespace App\Devintech\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Devintech\Service\MetierManagerBundle\Utils\CmsName;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DitFooterController extends Controller
{
    /**
     * Afficher la page footer
     * @param Request $_request
     * @return Render page
     */
    public function showAction(Request $_request)
    {
        // Récupérer manager

        return $this->render('FrontSiteBundle:DitFooter:index.html.twig', array(
        ));
    }
}