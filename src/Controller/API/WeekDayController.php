<?php

namespace App\Controller\API;

use App\Repository\WeekDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeekDayController extends AbstractController
{
    #[Route('/api/weekDays', name: 'app_weekDays_api', methods: ['GET'])]
    public function getWeekDays(WeekDayRepository $weekDayRepository):JsonResponse
    {
        $weekDays = $weekDayRepository->findAll();
        return $this->json($weekDays, Response::HTTP_OK, [], ['groups' => 'getWeekDays']);

    }

}