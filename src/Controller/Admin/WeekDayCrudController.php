<?php

namespace App\Controller\Admin;

use App\Entity\WeekDay;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WeekDayCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WeekDay::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Jour de la semaine');
    }

}
