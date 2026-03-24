<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livres;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/livres', name: 'livres_')]
class LivreController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(LivresRepository $livresRepository): Response
    {
        $livres = $livresRepository->findAll();

        return $this->render('Livres/index.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/details/{id<\d+>}', name: 'details')]
    public function details(int $id, LivresRepository $livresRepository): Response
    {
        $livre = $livresRepository->find($id);

        if (!$livre) {
            throw $this->createNotFoundException("Livre avec l'id $id non trouve");
        }

        return $this->render('Livres/details.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route("/ajouter", name: "ajouter")]
    public function ajouter(EntityManagerInterface $entityManager) : Response {
        // Creation d'un auteur puis d'un livre associe
        $auteur = new Auteur();
        $auteur->setNom("Dupont");
        $auteur->setPrenom("Jean");

        $symfony = new Livres();
        $symfony->setTitre("Apprendre Symfony 6");
        $symfony->setAnnee(new \DateTime('2025-01-01'));
        $symfony->setResume("Un livre complet pour apprendre le framework Symfony 6.");
        $symfony->setAuteur($auteur);

        $entityManager->persist($auteur);
        $entityManager->persist($symfony);
        $entityManager->flush();

        return new Response("Livre ajouté avec succès !");
    }
}
