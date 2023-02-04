<?php

namespace App\Controller\Admin;

use App\Entity\DailySchedule;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class DailyScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailySchedule::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TimeField::new('openingTime', 'Heure d\'ouverture');
        yield TimeField::new('closingTime', 'Heure de fermeture');
        yield AssociationField::new('weekDays', 'Jours')->onlyOnForms();
    }

}
