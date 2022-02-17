<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recette::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('quantity', 'Quantité requise (grammes)'),
            AssociationField::new('ingredient','Ingrédient'),
            AssociationField::new('produit','Produit correspondant à la recette'),
            
        ];
        
    }
    
}
