<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livres;
use App\Repository\LivresRepository;

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

    #[Route('/details/{slug}', name: 'details')]
    public function details(string $slug, LivresRepository $livresRepository): Response
    {
        $livre = $livresRepository->findOneBy(['slug' => $slug]);

        if (!$livre) {
            throw $this->createNotFoundException(sprintf('Livre avec le slug "%s" non trouve.', $slug));
        }

        return $this->render('Livres/details.html.twig', [
            'livre' => $livre,
        ]);
    }

}
