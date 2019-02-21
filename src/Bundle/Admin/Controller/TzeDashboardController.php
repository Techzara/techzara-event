<?php

namespace App\Bundle\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TzeDashboardController
 */
class TzeDashboardController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:TzeDashboard:index.html.twig');
    }
}
