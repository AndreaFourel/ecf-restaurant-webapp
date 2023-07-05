<?php

namespace App\Controller\Admin;

use App\Entity\Meal;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MealCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Meal::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Nom du plat');
        yield TextareaField::new('description', 'Description');
        yield NumberField::new('price', 'Prix')
            ->setNumDecimals(2);
        yield AssociationField::new('mealCategory', 'Catégorie')
            ->renderAsNativeWidget();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('mealCategory')
            ->add('title')
            ->add('description');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Les Plats')
            ->setEntityLabelInSingular('un plat');
    }

}
