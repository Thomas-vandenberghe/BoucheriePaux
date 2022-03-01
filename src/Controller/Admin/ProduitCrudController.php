<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;



class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
       return [
        TextField::new('name','Produit'),
        SlugField::new('slug')->setTargetFieldName('name')
        ->hideOnIndex(),
        ImageField::new('illustration', 'Img')->setBasePath('uploads/')
    ->setUploadDir('public/uploads/')
    ->setUploadedFileNamePattern('[randomhash].[extension]')
    ->setRequired(true),
        IntegerField::new('subtitle', 'Qté (gr)'),
        TextareaField::new('description'),
        BooleanField::new('publie', 'Publié'),
        BooleanField::new('enAvant', 'Favoris'),
        MoneyField::new('priceKg','Prix/kg')->setCurrency('EUR'),
        MoneyField::new('priceQuantity', 'Prix/portion')->setCurrency('EUR'),
        AssociationField::new('categorie')
       ];
    }
    
}
