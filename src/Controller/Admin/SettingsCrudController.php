<?php

namespace App\Controller\Admin;

use App\Entity\Settings;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SettingsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Settings::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('item', 'Elément');
        yield TextField::new('description', 'Description');
        yield TextField::new('value', 'Valeur');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Paramètres du restaurant')
            ->setEntityLabelInSingular('un paramètre');
    }

}
