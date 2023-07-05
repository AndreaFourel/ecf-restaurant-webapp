<?php

namespace App\Controller\API;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/api/reservations', name: 'app_reservation_api', methods: ['GET'])]
    public function getReservations(ReservationRepository $reservationRepository):JsonResponse
    {
        $reservations = $reservationRepository->findAll();

        //Returns a JsonResponse that uses the serializer component
        //headers array empty due to usage of JsonResponse instead of Response (content-type = application/json)
        return $this->json($reservations, Response::HTTP_OK, [], ['groups' => 'getReservations']);

    }
}