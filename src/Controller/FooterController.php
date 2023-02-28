<?php

namespace App\Controller;

use App\Entity\DailySchedule;
use App\Entity\Settings;
use App\Entity\WeekDay;
use App\Repository\WeekDayRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends AbstractController
{
    public function displaySchedule(ManagerRegistry $doctrine): Response
    {
        $weekDays = $doctrine->getRepository(WeekDay::class)->findAll();
        $dailySchedule = $doctrine->getRepository(DailySchedule::class)->findAll();
        $address = $doctrine->getRepository(Settings::class)->findOneByItemField('Adresse');
        $phoneNumber = $doctrine->getRepository(Settings::class)->findOneByItemField('Téléphone');
        $maxCapacity = $doctrine->getRepository(Settings::class)->findOneByItemField('Capacité maximale');
        $email = $doctrine->getRepository(Settings::class)->findOneByItemField('Email');

        return $this->render('layout_fragments/_footer.html.twig', [
            'weekDays' => $weekDays,
            'dailySchedule' => $dailySchedule,
            'address' => $address,
            'phoneNumber' => $phoneNumber,
            'maxCapacity' => $maxCapacity,
            'email' => $email,
        ]);
    }
}