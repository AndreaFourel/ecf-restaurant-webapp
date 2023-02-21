<?php

namespace App\Controller\Pages;

use App\Entity\Meal;
use App\Entity\MealCategory;
use App\Entity\MealMenu;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealDisplayController extends AbstractController
{
    #[Route('/carte-et-menus', name: 'app_meal_display')]
    public function mealDisplay(ManagerRegistry $doctrine): Response
    {
        $mealCategories = $doctrine->getRepository(MealCategory::class)->findAll();
        $meals = $doctrine->getRepository(Meal::class)->findAll();
        $mealMenu = $doctrine->getRepository(MealMenu::class)->findAll();
        //dd($meals);
        return $this->render('meal_display/meal_display.html.twig', [
            'title' => 'Carte et Menus',
            'mealCategories' => $mealCategories,
            'meals' => $meals,
            'mealMenu' => $mealMenu,
        ]);
    }
}
