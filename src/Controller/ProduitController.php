<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Produit;
use App\Form\SearchType as FormSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{

    
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/nos-produits', name: 'nos-produits')]


    public function index(Request $request): Response
    {
        

        $search = new Search;
        $form = $this->createForm(FormSearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $produits = $this->entityManager->getRepository(Produit::class)->findWithSearch($search);
        } else{
            $produits = $this->entityManager->getRepository(Produit::class)->findAll();
        }

        return $this->render('produit/index.html.twig',[
            'produits' => $produits,
            'form' => $form->createView()
        ]);
    }


    
    /**
     * @Route("produit/{slug}", name="produit")
     */
    public function show($slug): Response
    {
    
        // $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $produits = $this->entityManager->getRepository(Produit::class)->findAll();
        $produit = $this->entityManager->getRepository(Produit::class)->findOneBySlug($slug);
           if (!$produit){
               return $this->redirectToRoute('nos-produits');
           }
        return $this->render('produit/show.html.twig',[
            'produit' => $produit,
            'produits'=> $produits
            // 'products' => $products
        ]);
    }

}
