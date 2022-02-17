<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Recette;
use App\Entity\Commande;
use App\Entity\Categorie;
use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(CommandeCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Boucherie Paux');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard("Interface d'administration", 'fa fa-home');
        yield MenuItem::linkToCrud('utilisateur', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('produit', 'fa fa-tag', Produit::class);
       yield MenuItem::linkToCrud('Commandes', 'fas fa-shopping-cart', Commande::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Ingrédients', 'fa fa-cheese', Ingredient::class);
        yield MenuItem::linkToCrud('Recettes', 'fa fa-spoon', Recette::class);


    }
}
