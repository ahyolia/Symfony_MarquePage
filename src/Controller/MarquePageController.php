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

    #[Route("/ajouter", name: "ajouter")]
    public function ajouter(EntityManagerInterface $entityManager) : Response {
       // Création du marque-page Symfony
       $symfony = new MarquePage();
       $symfony->setUrl("https://symfony.com/");
       $symfony->setDateCreation(new \DateTime('2026-02-27'));
       $symfony->setCommentaire("Page officielle de Symfony");
       
       $ms1 = new MotsCle();
       $ms1->setNom("Symfony");
       $ms1->addMarquePage($symfony);

       $ms2 = new MotsCle();
       $ms2->setNom("PHP");
       $ms2->addMarquePage($symfony);

       $ms3 = new MotsCle();
       $ms3->setNom("MVC");
       $ms3->addMarquePage($symfony);
       
       $entityManager->persist($symfony);
       $entityManager->persist($ms1);
       $entityManager->persist($ms2);
       $entityManager->persist($ms3);

       // Création du marque-page Qwant
       $qwant = new MarquePage();
       $qwant->setUrl("https://www.qwant.com/");
       $qwant->setDateCreation(new \DateTime('2026-02-27'));
       $qwant->setCommentaire("Moteur de recherche français");
       
       $mc_qwant1 = new MotsCle();
       $mc_qwant1->setNom("Moteur de recherche");
       $mc_qwant1->addMarquePage($qwant);

       $mc_qwant2 = new MotsCle();
       $mc_qwant2->setNom("Recherche");
       $mc_qwant2->addMarquePage($qwant);

       $mc_qwant3 = new MotsCle();
       $mc_qwant3->setNom("Sécurité");
       $mc_qwant3->addMarquePage($qwant);
       
       $entityManager->persist($qwant);
       $entityManager->persist($mc_qwant1);
       $entityManager->persist($mc_qwant2);
       $entityManager->persist($mc_qwant3);

       // Création du marque-page LinkedIn
       $linkedin = new MarquePage();
       $linkedin->setUrl("https://www.linkedin.com/");
       $linkedin->setDateCreation(new \DateTime('2026-02-27'));
       $linkedin->setCommentaire("Réseau social professionnel");
       
       $ml1 = new MotsCle();
       $ml1->setNom("Réseau social");
       $ml1->addMarquePage($linkedin);

       $ml2 = new MotsCle();
       $ml2->setNom("Professionnel");
       $ml2->addMarquePage($linkedin);

       $ml3 = new MotsCle();
       $ml3->setNom("Contenus");
       $ml3->addMarquePage($linkedin);
       
       $entityManager->persist($linkedin);
       $entityManager->persist($ml1);
       $entityManager->persist($ml2);
       $entityManager->persist($ml3);
       
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