<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\Recette;
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
        $datemin = date('Y-m-d');
        $datemax = date('Y-m-d', strtotime("+10 days"));


        $commandes = $this->entityManager->getRepository(Commande::class)->findCommandesSemaine($datemin, $datemax);
        if(!$commandes){
            return $this->render('stock_admin/vide.html.twig');
        }
        foreach ($commandes as $commande){
            $com [] = $commande->getDetailsCommandes()->getValues();
        }

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
            for ($i=0; $i<count($id) ; $i++) { 

        if(isset($tableau[$id[$i]])  ){
                    $tableau[$id[$i]] = ($quantite[$i] + $tableau[$id[$i]]); 
                }
                else{
                    $tableau[$id[$i]] =  $quantite[$i] ;
                }
            }
// dd($i);
//   dd($tableau);
    // $recette = [];
                foreach ($tableau as $produit=>$quantite){
                    $recettes [] = $this->entityManager->getRepository(Recette::class)->findRecettes($produit);
                }
            
                foreach ( $recettes as $recette){
                    foreach($recette as $ingredient){
                    $portions[] = $ingredient->getQuantity();
                    $result [] = $ingredient->getIngredient()->getName(); 
                }
                
            }

            $tableIngredient = [];
            for ($i=0; $i<count($portions) ; $i++) { 

        if(isset($tableIngredient[$result[$i]])  ){
                    $tableIngredient[$result[$i]] = ($portions[$i] + $tableIngredient[$result[$i]]); 
                }
                else{
                    $tableIngredient[$result[$i]] =  $portions[$i] ;
                }
            }
            // dd($portions);
// dd($recette);
// dd($result);
dd($tableIngredient);



        return $this->render('stock_admin/index.html.twig', [
            'commandes' => $commandes,
            'produits' => $produits,
            

        ]
        );
    }
}