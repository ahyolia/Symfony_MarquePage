<?php

namespace App\Controller;

use App\Entity\MarquePage;
use App\Entity\MotsCle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;


#[Route("/MarquePage", name: "marquepage_")]
class MarquePageController extends AbstractController
{
    #[Route("/", name: "index")]
    public function index(EntityManagerInterface $entityManager): Response {

        $marquepages = $entityManager
        ->getRepository(MarquePage::class)
        ->findAll();
            
        return $this->render('MarquePage/index.html.twig', [
            'marquepages' => $marquepages
        ]);

        
    }
    
    #[Route("/details/{id<\d+>}", name: "details")]
    public function details(int $id, EntityManagerInterface $entityManager): Response {
        $marquepage = $entityManager
        ->getRepository(MarquePage::class)
        ->find($id);
        
        if (!$marquepage) {
            throw $this->createNotFoundException("Marque-page avec l'id $id non trouvé");
        }

        return $this->render('MarquePage/details.html.twig', [
            'marquepage' => $marquepage
        ]);
    }

    


}

?>