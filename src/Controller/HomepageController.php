<?php

namespace App\Controller;

use App\Entity\DailySchedule;
use App\Entity\Settings;
use App\Entity\WeekDay;
use App\Repository\ImageGalleryRepository;
use Doctrine\ORM\EntityManagerInterface;
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
