<?php

namespace App\Controller\Admin;

use App\Entity\ImageGallery;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use const http\Client\Curl\Versions\CURL;

class ImageGalleryCrudController extends AbstractCrudController
{
    public const BASE_PATH = 'upload/images/imagesGallery';
    public const UPLOAD_DIR_PATH = 'public/upload/images/imagesGallery';

    public static function getEntityFqcn(): string
    {
        return ImageGallery::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Nom du plat');
        yield ImageField::new('fileName', 'Image')
            ->setBasePath(self::BASE_PATH)
            ->setUploadDir(self::UPLOAD_DIR_PATH)
            ->setSortable(false);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('title');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Galerie d\'images')
            ->setEntityLabelInSingular('une image');
    }

}
