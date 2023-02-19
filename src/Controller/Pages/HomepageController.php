<?php

namespace App\Controller\Pages;

use App\Repository\ImageGalleryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ImageGalleryRepository $repository): Response
    {
        $images = $repository->findAll();
        //dd($images);
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'images' => $images
        ]);
    }

}
