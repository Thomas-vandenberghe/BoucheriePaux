<?php

namespace App\Controller;

use App\Classe\Panier;
// use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/index.html.twig',[
            'panier'=> $panier->getFull(),
        ]);
    }


    #[Route('/panier/ajouter/{id}', name: 'panier-ajouter')]
    public function ajouter(Panier $panier, $id): Response
    {
        $panier->ajouter($id);

        return $this->redirectToRoute('panier');

    }



    #[Route('/panier/ajouterCinq/{id}', name: 'panier-ajouter-cinq')]
    public function ajouterCinq(Panier $panier, $id): Response
    {
        $panier->ajouterCinq($id);

        return $this->redirectToRoute('panier');

    }



    #[Route('/panier/ajouterVersProduits/{id}', name: 'panier-ajouter-vers-produits')]
    public function ajouterVersProduits(Panier $panier, $id): Response
    {
        $panier->ajouterVersProduits($id);

        return $this->redirectToRoute('nos-produits');

    }

    
   
    #[Route('/panier/vider', name: 'panier-vider')]
    public function remove(Panier $panier): Response
    {
        $panier->vider();
        
        return $this->redirectToRoute('nos-produits');
    }



    #[Route('/panier/supprimer/{id}', name: 'panier-supprimer')]
    public function supprimer(Panier $panier, $id): Response
    {
        $panier->supprimer($id);
        
        return $this->redirectToRoute('panier');
    }


    #[Route('/panier/reduire/{id}', name: 'panier-reduire')]
    public function reduire(Panier $panier, $id): Response
    {
        $panier->reduire($id);
        
        return $this->redirectToRoute('panier');
    }


    #[Route('/panier/reduireCinq/{id}', name: 'panier-reduire-cinq')]
    public function reduireCinq(Panier $panier, $id): Response
    {
        $panier->reduireCinq($id);
        
        return $this->redirectToRoute('panier');
    }


    #[Route('/badge-panier', name: 'badge-panier')]
    public function getBadge(Panier $panier): Response
    {
        return $this->render('badgePanier.html.twig',[
            'panier'=> $panier->getFull(),
        ]);
    }

} 
