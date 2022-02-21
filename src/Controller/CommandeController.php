<?php

namespace App\Controller;

use DateTime;
use App\Classe\Panier;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\DetailCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/commande', name: 'commande')]
    public function index(Panier $panier, Request $request): Response
    {

        $form = $this->createForm(CommandeType::class, null, [
            'user'=>$this->getUser()
        ]);


        return $this->render('commande/index.html.twig',[
            'form'=> $form->createView(),
            'panier'=> $panier->getFull()
        ]);
    }


    #[Route('/commande/validation', name: 'commande-validation', methods: 'POST')]
    public function validation(Panier $panier, Request $request): Response
    {
        $form = $this->createForm(CommandeType::class, null, [
            'user'=>$this->getUser(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            

            $createdAt = new DateTime();
            $finishedAt = $form->get('finishedAt')->getData();

             // enregistrer ma commade Order
             $commande = new Commande();
             $reference =  $createdAt->format('dmY').'-'.uniqid();
             $commande->setReference($reference);
             $commande->setUser($this->getUser());
             $commande->setCreatedAt($createdAt);
             $commande->setFinishedAt($finishedAt);
            
             $commande->setEtat(0);
 
             $this->entityManager->persist($commande);
        

    //Enregistrer emms produits DetailCommande

           

        foreach ($panier->getFull() as $produit)
        {
            $DetailCommande = new DetailCommande();
            $DetailCommande->setCommande($commande);
            $DetailCommande->setProduct($produit['produit']->getName());
            $DetailCommande->setQuantity($produit['quantity']);
            $DetailCommande->setPrice($produit['produit']->getPriceQuantity());
            $DetailCommande->setTotal($produit['produit']->getPriceQuantity() * $produit['quantity']   );
            $this->entityManager->persist($DetailCommande);
        }

        $this->entityManager->flush(); 

        return $this->render('commande/commande-validation.html.twig',[
            // 'form'=> $form->createView(),
            'DetailCommande'=> $DetailCommande,
            'commande'=> $commande,
            'panier'=>$panier->getFull(),
            'reference'=>$commande->getReference()
        ]);
    }

    return $this->redirectToRoute('panier');

    }

}