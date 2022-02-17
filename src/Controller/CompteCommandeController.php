<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteCommandeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/mon-compte/mes-commandes', name: 'compte-commande')]

    public function index(): Response
    {
        $commandes = $this->entityManager->getRepository(Commande::class)->findCommandesPayees($this->getUser());

        return $this->render('compte_commande/index.html.twig',[
            'commandes' => $commandes
        ]);
    }


    #[Route('/mon-compte/mes-commandes/{{reference}}', name: 'compte-commande-afficher')]

    public function show($reference): Response
    {
        $commande = $this->entityManager->getRepository(Commande::class)->findOneBy(['reference' => $reference]);

        if(!$commande || $commande->getUser() != $this->getUser()){
            return $this->redirectToRoute('compte-commande');
        }

        return $this->render('compte_commande/commande_unique.html.twig',[
            'commande' => $commande
        ]);
    }
}
