<?php

namespace App\Controller\Pages;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{

    #[Route('/reservation', name: 'app_reservation')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $reservation->setCreatedAt(new \DateTimeImmutable('now'));
            $entityManager = $doctrine->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }


        return $this->render('reservation/reservation.html.twig', [
            'controller_name' => 'ReservationController',
            //'settings' => $settings,
            'reservationForm' =>$form->createView(),
        ]);
    }
}
