<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auteur', name: 'auteur_')]
class AuteurController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(AuteurRepository $auteurRepository): Response
    {
        $auteurs = $auteurRepository->findBy([], ['nom' => 'ASC', 'prenom' => 'ASC']);

        return $this->render('auteur/index.html.twig', [
            'auteurs' => $auteurs,
        ]);
    }

    #[Route('/details/{slug}', name: 'details')]
    public function details(string $slug, AuteurRepository $auteurRepository): Response
    {
        $auteur = $auteurRepository->findOneBy(['slug' => $slug]);

        if (!$auteur) {
            throw $this->createNotFoundException(sprintf('Auteur avec le slug "%s" introuvable.', $slug));
        }

        return $this->render('auteur/details.html.twig', [
            'auteur' => $auteur,
        ]);
    }
}
