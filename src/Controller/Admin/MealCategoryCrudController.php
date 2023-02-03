<?php

namespace App\Controller\Admin;

use App\Entity\MealCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MealCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MealCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Nom de la catégorie');
        yield AssociationField::new('meals', 'Les plats')->renderAsNativeWidget()->onlyOnForms();
    }

}
