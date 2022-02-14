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

} 