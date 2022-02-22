<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockAdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
    }
    #[Route('/stock/admin', name: 'stock_admin')]
    public function index(): Response
    {
        $date = date('Y-m-d', strtotime("+3 days"));

        $commandes = $this->entityManager->getRepository(Commande::class)->findCommandesSemaine($date);
        if(!$commandes){
            return $this->render('stock_admin/vide.html.twig');
        }
        foreach ($commandes as $commande){
            $com [] = $commande->getDetailsCommandes()->getValues();
        }
// dd($commandes);
        foreach ($com as $co){
            foreach ($co as $produit){
                $produits []=  $this->entityManager->getRepository(Produit::class)->findProduitsCommandesSemaine($produit->getProduct());
                $quantite []= $produit->getQuantity();
                }
            } 

        foreach ($produits as $produitUniques){
                foreach ($produitUniques as $produitUnique){
                    $id []= $produitUnique->getId();
        }
    }
    
    
    $tableau = [];
    for ($i=0; $i < count($id) ; $i++) { 
        $tableau []= [ $id[$i] => $quantite[$i]];
    }
// dd($tableau);
    foreach ($tableau as $table) {
        foreach ($table as $produit => $quantite) {
        //   $merged[$produit] = $quantite + ($merged[$produit] ?? 0); 
        }
    }
    // dd($table);
    dd($sum);
                             // iterate both arrays
                             

                           

    // dd($tableau);
                // dd($quantite);
                // dd($com);

                // => $produit->getQuantity()]
        // $produits = $this->entityManager->getRepository(DetailCommande::class)->findProduitsCommandesSemaine($id);
          

        // dd($produits);

        return $this->render('stock_admin/index.html.twig', [
            'commandes' => $commandes,
            'produits' => $produits,
            

        ]
        );
    }
}