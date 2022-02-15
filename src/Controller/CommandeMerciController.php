<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeMerciController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci/{stripeSessionId}', name: 'commande_merci')]

    public function index(Panier $panier, $stripeSessionId): Response
    {
        $commande = $this->entityManager->getRepository(Commande::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$commande || $commande->getUser() != $this->getUser() ){
            return $this->redirectToRoute('home');
        }

        if ($commande->getEtat() == 0) {

        // Vider la SessionCart.
          $panier->vider();   

         //Modifier le statut isPaid de notre commande en passanr le boolean à 1
         $commande->setEtat(1);
         $this->entityManager->flush();

        //Envoyer un mail a notre client pour valider sa commande
        
        // $mail = new Mail();
        // $content ="Bonjour ".$order->getUser()->getFirstName()."<br>Merci pour votre commande. <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut at repellat quia aperiam,<br> amet dolorem? Dolorem doloribus, nam ullam ab quaerat fugit nisi. Provident, reiciendis. ";

        // $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstName(), 'Votre commande La Boutique Francaise est bien validée', $content);

        }
        

        //Afficher les quelques infos de la commande de l'utilisateur.
       

        return $this->render('commande_merci/index.html.twig',[
            'commande'=>$commande,
        ]);
    }
}
