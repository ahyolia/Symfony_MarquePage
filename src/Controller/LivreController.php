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

}
