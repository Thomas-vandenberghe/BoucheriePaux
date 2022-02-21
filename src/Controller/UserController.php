<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    private $entityManager ;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager ;
    }

    #[Route('/inscription', name: 'inscription')]
    public function index( Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $notification = null ;

        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
            $search_email = $this->entityManager->getRepository(User::class)->findOneBy(['email'=>$user->getEmail()]);
                if(!$search_email){
                    $password = $passwordHasher->hashPassword($user, $user->getPassword());
                    $user->setPassword($password);

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();

                    $mail = new Mail();
                    $content = "Bonjour ".$user->getFirstname()."<br/> Bienvenue sur le site de la  boucherie Paux.<br/> Votre inscription a bien été prise en compte, vous pouvez dès à présent profiter des fonctionnalités que vous offre le site";
                    
                    $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur La Boucherie Paux', $content);

                    $this->addFlash('success', 'Votre inscription a bien été prise en compte. Vous pouvez déjà vous connecter.');

                    return $this->redirectToRoute('connexion');
                    //ici ce sera le mail
                }else{
                    $notification = "L'email que vous avez renseigné existe déjà.";
                }

        }

        return $this->render('user/index.html.twig',[
            'form' => $form->createView(),
            'notification' => $notification
            
        ]);
    }
}
