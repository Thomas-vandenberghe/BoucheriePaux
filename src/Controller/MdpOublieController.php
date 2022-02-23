<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\MdpOublie;
use App\Entity\User;
use App\Form\MdpOublieType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class MdpOublieController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mot-de-passe-oublie', name: 'mot-de-passe-oublie')]

    public function index(Request $request): Response
    {
        if($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            
            if($user) {
                // 1 : Enregister en base la demande de reset password avec user, token et createdAt.

                $mdp_oublie = new MdpOublie();
                $mdp_oublie->setUser($user);
                $mdp_oublie->setToken(uniqid());
                $mdp_oublie->setCreatedAt(new \DateTime());

                $this->entityManager->persist($mdp_oublie);
                $this->entityManager->flush();

                // 2 : Envoyer un mail à l'utilisateur avec un lien lui permettant de mettre à jour son Mdp

                $url = $this->generateUrl('modifier-mot-de-passe-oublie', [
                    'token' => $mdp_oublie->getToken()
                ]);

                $content = "Bonjour ".$user->getFirstname()."<br>Vous avez demandé à réinitialiser votre mot de passe sur la Boucherie Paux.<br><br>";
                $content .= "Merci de bien vouloir cliquer sur le lien suivant pour <a href='".$url."'>mettre à jour votre mot de passe</a>.";

                

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), 'Réinitialiser votre mot de passe sur la boucherie Paux', $content);

                $this->addFlash('notice', 'Vous allez recevoir dans quelques secondes un mail avec la procédure pour réinitialiser votre mot de passe.');
            }else {
                $this->addFlash('notice', 'Cette adresse email est inconnue.');
            }
        }

        return $this->render('mdp_oublie/index.html.twig');
    }

    #[Route('/modifier-mot-de-passe-oublie/{token}', name: 'modifier-mot-de-passe-oublie')]

    public function modifier(Request $request, $token, UserPasswordHasherInterface $passwordHasher)
    {
        $mdp_oublie = $this->entityManager->getRepository(MdpOublie::class)->findOneByToken($token);

        if(!$mdp_oublie) {
            return $this->redirectToRoute('mot-de-passe-oublie');
        }
        //  verifier si createdAT = maintenant - 3h

        $now = new DateTime();
        if($now > $mdp_oublie->getCreatedAt()->modify('+ 3 hour')) {
            
            $this->addFlash('notice', 'Votre demande de mor de passe à expirée. Merci de la renouveller.');
            return $this->redirectToRoute('mot-de-passe-oublie');
        }
        
        // Rendre une vue avec mot de passe et confirmer votre mot de passe
        $form = $this->createForm(MdpOublieType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $new_password = $form->get('password')->getData(); 

        // Encodage des Mdp
            $password = $passwordHasher->hashPassword($mdp_oublie->getUser(), $new_password);
            $mdp_oublie->getUser()->setPassword($password);

        // Flush en base de donnée.
            $this->entityManager->flush();

        // Redirection de l'utilisateur vers la page de connexion.
            $this->addFlash('notice', 'Votre mot de passe a bien été mis à jour.');
            return $this->redirectToRoute('connexion');

        }


        return $this->render('mdp_oublie/modifier.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
