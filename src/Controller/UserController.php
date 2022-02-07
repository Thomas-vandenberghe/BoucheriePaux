<?php

namespace App\Controller;

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

                    //ici ce sera le mail
                }
        }

        return $this->render('user/index.html.twig',[
            'form' => $form->createView(),
            
        ]);
    }
}
