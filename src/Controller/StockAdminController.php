<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
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
dd($commandes->getDetailsCommandes()->getId());
        foreach ($commandes as $commande){

        $com = $commande->getDetailsCommandes()->getValues();
            // $produits = $this->entityManager->getRepository(DetailCommande::class)->findProduitsCommandesSemaine($id);
            
}dd($com);

        
// dd($commandes);
        return $this->render('stock_admin/index.html.twig', [
            'commandes' => $commandes,
            // 'produits' => $produits,
            'com' => $com
        ]
        );
    }
}
