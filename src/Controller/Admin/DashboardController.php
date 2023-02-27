<?php

namespace App\Controller\Admin;

use App\Entity\DailySchedule;
use App\Entity\ImageGallery;
use App\Entity\Meal;
use App\Entity\MealCategory;
use App\Entity\MealMenu;
use App\Entity\Reservation;
use App\Entity\Settings;
use App\Entity\User;
use App\Entity\WeekDay;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ReservationCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        //return $this->render('admin/meal_display.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La Bouche Des Goûts');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToUrl('Page d\'accueil', 'fa fa-home', $_ENV['HOME_PATH']);

        yield MenuItem::section('Gestion des Réservations');
        yield MenuItem::linkToCrud('Les Réservations', 'fa fa-utensils', Reservation::class);

        yield MenuItem::section('La carte');
        yield MenuItem::linkToCrud('Les catégories', 'fa fa fa-tags', MealCategory::class);
        yield MenuItem::linkToCrud('Les plats', 'fa fa-bowl-food', Meal::class );
        yield MenuItem::linkToCrud('Les menus', 'fa fa-clipboard-list', MealMenu::class);

        yield MenuItem::section('Galerie d\'images');
        yield MenuItem::linkToCrud('Toutes les images', 'fa fa-image', ImageGallery::class);

        yield MenuItem::section('Gestion du restaurant');
        yield MenuItem::linkToCrud('Détails du restaurant', 'fa fa-cog', Settings::class);
        yield MenuItem::linkToCrud('Jours de la semaine', 'fa fa-calendar-days', WeekDay::class);
        yield MenuItem::linkToCrud('Plages horaires', 'fa fa-clock', DailySchedule::class)->setDefaultSort(['openingTime' =>'ASC']);

        yield MenuItem::section('Gestion des utilisateurs')
            ->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('Les utilisateurs', 'fa-solid fa-users', User::class)
            ->setPermission('ROLE_SUPER_ADMIN');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->setPaginatorPageSize(15)
            ->showEntityActionsInlined()
            ->setSearchFields(null);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()->setPermission(Action::BATCH_DELETE, 'ROLE_SUPER_ADMIN');
    }

}
