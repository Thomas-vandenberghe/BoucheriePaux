<?php

namespace App\Classe;


use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Panier
{
    private $session;
    private $entityManager;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session=$session;
        $this->entityManager = $entityManager;
    }

    public function ajouter($id)
    {
        $panier = $this->session->get('panier',[]);

        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        }else{
            $panier[$id]=1;
        }

        $this->session->set('panier', $panier);

    }

    public function ajouterVersProduits($id)
    {
        $panier = $this->session->get('panier',[]);

        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        }else{
            $panier[$id]=1;
        }

        $this->session->set('panier', $panier);

    }

    public function get()
    {
        return $this->session->get('panier');
    }

    public function vider()
    {
        return $this->session->remove('panier');
    }


    public function supprimer($id)
    {
        $panier = $this->session->get('panier',[]);

        unset($panier[$id]);

        return $this->session->set('panier', $panier);
    }


    public function reduire($id)
    {
        $panier = $this->session->get('panier',[]);
        if($panier[$id] > 1){
            $panier[$id]--;
        }else{
            unset($panier[$id]);
        }
        return $this->session->set('panier', $panier);
    }

    public function getFull(){

        $panierComplete = [];

        if($this->get()){
            foreach( $this->get() as $id=>$quantity){
                $product_object=$this->entityManager->getRepository(Produit::class)->findOneById($id);
                if(!$product_object){
                    $this->supprimer($id);
                    continue;
                }
            $panierComplete[] = [
                'produit'=> $product_object,
                'quantity'=> $quantity
            ];
            }
        }
        return $panierComplete ;
    } 
}