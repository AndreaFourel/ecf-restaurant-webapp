<?php

namespace App\Controller\Admin;

use App\Entity\WeekDay;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
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
        yield BooleanField::new('open', 'Ouvert');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Jours de la semaine')
            ->setEntityLabelInSingular('un jour');
    }
}
