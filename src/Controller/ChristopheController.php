<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChristopheController extends AbstractController
{
    #[Route('/christophe', name: 'christophe')]
    public function index(): Response
    {
        return $this->render('christophe/index.html.twig', [
            'controller_name' => 'ChristopheController',
        ]);
    }
}
