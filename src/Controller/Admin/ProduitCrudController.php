<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
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
        TextField::new('name','Nom du produit'),
        SlugField::new('slug')->setTargetFieldName('name'),
        ImageField::new('illustration')->setBasePath('uploads/')
    ->setUploadDir('public/uploads/')
    ->setUploadedFileNamePattern('[randomhash].[extension]')
    ->setRequired(false),
        IntegerField::new('subtitle', 'Quantité par portion (en gramme)'),
        TextareaField::new('description'),
       // BooleanField::new('isBest'),
        MoneyField::new('priceKg','Prix au Kg')->setCurrency('EUR'),
        MoneyField::new('priceQuantity', 'Prix par portion')->setCurrency('EUR'),
        AssociationField::new('categorie')
       ];
    }
    
}
