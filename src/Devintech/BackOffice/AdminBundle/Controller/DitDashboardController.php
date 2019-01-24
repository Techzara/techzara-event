<?php

namespace App\Devintech\BackOffice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Devintech\Service\MetierManagerBundle\Utils\ServiceName;

/**
 * Class DitDashboardController
 */
class DitDashboardController extends Controller
{
    /**
     * Afficher le tableau de bord
     * @return Render page
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:DitDashboard:index.html.twig');
    }
}
