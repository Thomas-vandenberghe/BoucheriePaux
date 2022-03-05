<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;

// Include Dompdf required namespaces
use Dompdf\Options;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfController extends AbstractController
{

private $entityManager;    
public function __construct(EntityManagerInterface $entityManager)
{
    $this->entityManager = $entityManager;
}
    
    #[Route('/pdf/{{reference}}', name: 'pdf')]

    public function index($reference)
    {
        $commandepdf =  $this->entityManager->getRepository(Commande::class)->findOneByReference($reference);
            $vide = 1;
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        
        $pdfOptions->set('defaultFont', 'Time New Roman');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // $dompdf->set_option('pdfBackend', 'GD');
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('compte_commande/commande_unique.html.twig', [
            'commande'=>$commandepdf,
            'vide' =>$vide,
            
    
        ]);
       
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
       
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("facture.pdf", [
            "Attachment" => false
        ]);
//  dd($html);

    }



    // #[Route('/pdf/voir/{{reference}}', name: 'pdf-voir')]

    // public function voir($reference)
    // {
    //     $commandepdf =  $this->entityManager->getRepository(Commande::class)->findOneByReference($reference);
    // return $this->render('compte_commande/facture.html.twig', [
    //     'commande'=>$commandepdf,
        

    // ]);
    // }



}