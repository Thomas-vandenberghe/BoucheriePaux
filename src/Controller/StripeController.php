<?php

namespace App\Controller;


use Stripe\Stripe;
use App\Classe\Panier;
use App\Entity\Produit;
use App\Entity\Commande;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{


    #[Route('/commande/create-session/{reference}', name:'stripe_create_session')]

    public function index(EntityManagerInterface $entityManager, Panier $panier, $reference): Response
    {
        $productsForStripe = [];
        $DOMAIN = "http://127.0.0.1:8000";

        $commande = $entityManager->getRepository(Commande::class)->findOneByReference($reference);

        if(!$commande){
            new JsonResponse(['id' => 'commande']);
        }

        foreach ($commande->getDetailsCommandes()->getValues() as $produit) {
            $product_object = $entityManager->getRepository(Produit::class)->findOneByName($produit->getProduct());
            $productsForStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $produit->getPrice(),
                    'product_data' => [
                        'name' => $produit->getProduct(),
                        // 'images' => [$DOMAIN.'/uploads/'.$product_object->getIllustration()], 
                    ],
                ],
                'quantity' => $produit->getQuantity()
            ];
        }
        
        Stripe::setApiKey('sk_test_51KNvM5HEXSAkgjcrUsoOy84WLOIrd8n0uqk79ZutAu70fRJkt0OQ7F318aaRTZIJ8N3qWWwKnJfopbR5tnr9GdpZ00V7irFSKA');

        $checkout_session = Session::create([
            'customer_email' =>$this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [$productsForStripe],
            'mode' => 'payment',
            'success_url' => $DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);

        $commande->setStripeSessionId( $checkout_session->id);
        $entityManager->flush();

        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;
    }
}
