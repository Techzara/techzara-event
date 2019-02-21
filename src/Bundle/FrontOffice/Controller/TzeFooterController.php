<?php

namespace App\Bundle\FrontOffice\Controller;

use App\Shared\Entity\TzeEmailNewsletter;
use App\Shared\Form\TzeEmailNewsletterType;
use App\Shared\Services\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TzeFooterController extends Controller
{
    /**
     * @param Request $_request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function showAction(Request $_request)
    {
        $_email_manager = $this->get(ServiceName::SRV_METIER_EMAIL_NEWSLETTER);

        $_email = new TzeEmailNewsletter();
        $_form  = $this->createCreateForm($_email);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement email
            $_email_manager->saveEmailNewsletter($_email, 'new');
            $this->addFlash('info','Email add successful');
            return $this->redirect($this->generateUrl('home_site_index'));
        }

        return $this->render('FrontSiteBundle:TzeFooter:index.html.twig', array(
            'email_newsletter' => $_email,
            'form'             => $_form->createView()
        ));
    }

    private function createCreateForm(TzeEmailNewsletter $_email)
    {
        $_form = $this->createForm(TzeEmailNewsletterType::class, $_email, array(
            'action' => $this->generateUrl('email_news_new'),
            'method' => 'POST'
        ));

        return $_form;
    }
}