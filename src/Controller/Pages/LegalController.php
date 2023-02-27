<?php

namespace App\Controller\Pages;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/mentions-légales', name: 'app_legal')]
    public function index(): Response
    {
        return $this->render('legal/index.html.twig', [
            'title' => 'Mentions légales',
        ]);
    }
}
