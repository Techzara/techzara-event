<?php

namespace App\Tzevent\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Tzevent\Service\MetierManagerBundle\Utils\CmsName;
use App\Tzevent\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TzeFooterController extends Controller
{
    /**
     * @param Request $_request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $_request)
    {
        // Récupérer manager

        return $this->render('FrontSiteBundle:TzeFooter:index.html.twig', array(
        ));
    }
}