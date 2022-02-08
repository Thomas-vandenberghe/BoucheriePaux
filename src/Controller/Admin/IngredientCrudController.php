<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ingredient::class;
    }

     
    public function configureFields(string $pageName): iterable
    {
    return [
    TextField::new('name', 'Nom'),
    ChoiceField::new('unit', 'Unité')->renderExpanded()->setChoices([
        'grammes' => 'grammes',
        'millilitres' => 'millilitres'
    ])
    ];
}
}