<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email', 'Email');
        yield TextField::new('firstName', 'Prénom');
        yield NumberField::new('guestQuantity', 'Nombre de couverts');
        yield TextField::new('allergyList', 'Alérgies');
        yield DateField::new('reservationDay', 'Jour de la réservation')->setFormat('dd MMMM yyyy');
        yield TextField::new('reservationTime', 'Heure d\'arrivée')->onlyOnIndex();
        yield TextField::new('reservationTime', 'Heure d\'arrivée(format à respecter: hh:mm, (exemple: 13:00)')->hideOnIndex();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('reservationDay')
            ->add('email')
            ->add('firstName')
            ->add('allergyList');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->setPermission(Action::BATCH_DELETE, 'ROLE_ADMIN');
    }

}
