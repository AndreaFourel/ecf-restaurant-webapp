<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $roles = ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_USER'];

        yield EmailField::new('email', 'Email');
        yield TextField::new('firstName', 'Prénom');
        yield TextField::new('allergyList', 'Allergies alimentaires');
        yield NumberField::new('guestQuantity', 'Nombre de convives');
        yield ChoiceField::new('roles', 'Rôles')
            //create an array where $roles items are both the keys and the values
            ->setChoices(array_combine($roles, $roles))
            ->allowMultipleChoices()
            //render choices as check boxes
            ->renderExpanded()
            // all values are rendered with the same badge style (Bootstrap's ' secondary' style)
            ->renderAsBadges();
        yield TextField::new('password', 'Mot de passe')->onlyWhenCreating();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Les utilisateurs')
            ->setEntityLabelInSingular('un utilisateur');
    }

}
