<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommandeCrudController extends AbstractCrudController
{
    private $entityManager;
    private $crudUrlGenerator;
    
    public function __construct(EntityManagerInterface $entityManager, CrudUrlGenerator $crudUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->crudUrlGenerator = $crudUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Commande prête', 'fas fa-box-open')->linkToCrudAction('updatePreparation');

        return $actions
        ->add('detail', $updatePreparation)
        ->add('index', 'detail')
        ->remove('index', 'edit')
        ->remove('index', 'delete')
        ->remove('detail', 'edit')
        ->remove('detail', 'delete');
    }

    public function updatePreparation(AdminContext $context)
    {
        $commande = $context->getEntity()->getInstance();
        $commande->setEtat(2);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span style='color:green;'><strong>La commande ".$commande->getReference()." est <u>prête à être retirée à la boutique</u>.</strong></span>");

        $routeBuilder = $this->get(AdminUrlGenerator::class);

return $this->redirect($routeBuilder->setController(CommandeCrudController::class)->setAction('index')->generateUrl());

        }




    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' =>'DESC']);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('createdAt', 'Passée le'),
            TextField::new('user.lastname', "Nom"),
            TextField::new('user.firstname', "Prénom"),
            MoneyField::new('total', 'Total produit')->setCurrency('EUR'),
            ChoiceField::new('etat')->setChoices([
                'Non payée' => 0,
                'Payée' => 1,
                'prête' => 2,
            ]),
            ArrayField::new('detailsCommandes', 'Produits achetés')->hideOnIndex()
        ];
    }
    
}
