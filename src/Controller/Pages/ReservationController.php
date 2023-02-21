<?php

namespace App\Controller\Pages;

use App\Entity\Reservation;
use App\Entity\Settings;
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

        $user =$this->getUser();
        $settings = $doctrine->getRepository(Settings::class)->findOneByItemField('Capacité maximale');

        $reservation = new Reservation();

        if($user){
            $reservation->setEmail($user->getUserIdentifier());
            $reservation->setFirstName($user->getFirstName());
            $reservation->setAllergyList($user->getAllergyList());
        }
        $reservation->setCreatedAt(new \DateTimeImmutable('now'));

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $doctrine->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_confirmation');
        }


        return $this->render('reservation/reservation.html.twig', [
            'title' => 'Reservation',
            'settings' => $settings,
            'reservationForm' =>$form->createView(),
        ]);
    }

    #[Route('/reservation/confirmation', name: 'app_reservation_confirmation')]
    public function confirmation(): Response
    {
        return  $this->render('reservation/confirmation.html.twig', [
            'title' => 'Confirmation de réservation'
        ]);

    }
}
