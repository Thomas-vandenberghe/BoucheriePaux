<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Classe\Panier;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        
        $mail = new Mail();

        $content = "Bonjour ".$commande->getUser()->getFirstname()."<br/><br/> Merci pour votre commande.<br/><br/> Votre commande est bien validée, vous pourrais récupérer votre commande à la date indiquée lors de la validation. <br/><br/> boucherie Paux vous remercie de votre confiance et vous souhaite bonne dégustation.";
        
        $mail->send($commande->getUser()->getEmail(), $commande->getUser()->getFirstname(), 'Votre commande sur la Boucherie Paux est bien validée.', $content);

        }
        

        //Afficher les quelques infos de la commande de l'utilisateur.
       

        return $this->render('commande_merci/index.html.twig',[
            'commande'=>$commande,
        ]);
    }
}
