<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use Doctrine\DBAL\Types\DateTimeType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

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
        yield DateTimeField::new('reservationDay', 'Jour de la réservation')->setFormat('dd MMMM yyyy');
        yield TextField::new('reservationTime', 'Heure d\'arrivée');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('reservationDay')
            ->add('email')
            ->add('firstName')
            ->add('allergyList');
    }

}
