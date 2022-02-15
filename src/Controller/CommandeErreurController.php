<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeErreurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/erreur/{stripeSessionId}', name: 'commande_erreur')]
    public function index($stripeSessionId): Response
    {

        $commande = $this->entityManager->getRepository(Commande::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$commande || $commande->getUser() != $this->getUser() ){
            return $this->redirectToRoute('home');
        } 

        //Envoyer un email à notre user pour notifier de l'echec du paiement
        // $mail = new Mail();
        // $content ="Bonjour ".$order->getUser()->getFirstName()."<br> Il semblerait que nous ayons rencontré un probleme lors de la transaction, aucun débit n'a été effectué. <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut at repellat quia aperiam,<br> amet dolorem? Dolorem doloribus, nam ullam ab quaerat fugit nisi. Provident, reiciendis. ";

        // $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstName(), 'Votre commande La Boutique Francaise a échoué', $content);

        return $this->render('commande_erreur/index.html.twig',[
            'commande'=>$commande,
        ]);
    }
}
