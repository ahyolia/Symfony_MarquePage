<?php

namespace App\Controller;

use App\Entity\MarquePage;
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

    #[Route("/ajouter", name: "ajouter")]
    public function ajouter(EntityManagerInterface $entityManager) : Response {
       // Création du marque-page Symfony
       $symfony = new MarquePage();
       $symfony->setUrl("https://symfony.com/");
       $symfony->setDateCreation(new \DateTime('2026-02-27'));
       $symfony->setCommentaire("Page officielle de Symfony");
       $entityManager->persist($symfony);

       // Création du marque-page Qwant
       $qwant = new MarquePage();
       $qwant->setUrl("https://www.qwant.com/");
       $qwant->setDateCreation(new \DateTime('2026-02-27'));
       $qwant->setCommentaire("Moteur de recherche français");
       $entityManager->persist($qwant);

       // Création du marque-page LinkedIn
       $linkedin = new MarquePage();
       $linkedin->setUrl("https://www.linkedin.com/");
       $linkedin->setDateCreation(new \DateTime('2026-02-27'));
       $linkedin->setCommentaire("Réseau social professionnel");
       $entityManager->persist($linkedin);
       
       // Sauvegarde en base de données
       $entityManager->flush();

       // Retour après avoir tout sauvegardé
       return new Response("3 marque-pages sauvegardés avec succès !");
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