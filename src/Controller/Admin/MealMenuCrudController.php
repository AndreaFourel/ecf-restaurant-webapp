<?php

namespace App\Controller\Admin;

use App\Entity\MealMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use const http\Client\Curl\Versions\CURL;

class MealMenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MealMenu::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Nom');
        yield TextField::new('shortDescription', 'Description courte');
        yield TextareaField::new('description', 'Description détaillée');
        yield MoneyField::new('price', 'Prix')->setCurrency('EUR');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Les menus')
            ->setEntityLabelInSingular('un menu');
    }

}
