<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/page/cgv', name: 'app_page_cgv')]
    public function cgv(): Response
    {
        return $this->render('page/cgv.html.twig');
    }

    #[Route('/page/cgu', name: 'app_page_cgu')]
    public function cgu(): Response
    {
        return $this->render('page/cgu.html.twig');
    }

    #[Route('/page/mentions-legales', name: 'app_page_mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('page/mentions-legales.html.twig');
    }

    #[Route('/page/politique-confidentialite', name: 'app_page_politique_confidentialite')]
    public function politiqueConfidentialite(): Response
    {
        return $this->render('page/politique-confidentialite.html.twig');
    }

    #[Route('/page/livraison-retours', name: 'app_page_livraison_retours')]
    public function livraisonRetours(): Response
    {
        return $this->render('page/livraison-retours.html.twig');
    }

    #[Route('/page/contact', name: 'app_page_contact')]
    public function contact(): Response
    {
        return $this->render('page/contact.html.twig');
    }

    #[Route('/page/faq', name: 'app_page_faq')]
    public function faq(): Response
    {
        return $this->render('page/faq.html.twig');
    }

    #[Route('/page/qui-sommes-nous', name: 'app_page_qui_sommes_nous')]
    public function quiSommesNous(): Response
    {
        return $this->render('page/qui-sommes-nous.html.twig');
    }

    #[Route('/page/guide-parfum', name: 'app_page_guide_parfum')]
    public function guideParfum(): Response
    {
        return $this->render('page/guide-parfum.html.twig');
    }
}