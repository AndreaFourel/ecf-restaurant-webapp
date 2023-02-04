<?php

namespace App\Controller\Admin;

use App\Entity\Settings;
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
        yield TextField::new('item', 'Item');
        yield TextField::new('description', 'Description');
        yield TextField::new('value', 'Valeur');
    }

}
