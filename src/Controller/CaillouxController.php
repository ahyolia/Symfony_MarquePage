<?php

namespace App\Controller;

use App\Entity\Cailloux;
use App\Repository\CaillouxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cailloux', name: 'cailloux_')]
class CaillouxController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CaillouxRepository $caillouxRepository): Response
    {
        $cailloux = $caillouxRepository->findAll();

        return $this->render('Cailloux/index.html.twig', [
            'cailloux' => $cailloux,
            'categorie_active' => null,
        ]);
    }

    #[Route('/categorie/{categorie}', name: 'categorie')]
    public function categorie(string $categorie, CaillouxRepository $caillouxRepository): Response
    {
        $categorieNormalisee = ucfirst(mb_strtolower($categorie));

        if (!in_array($categorieNormalisee, ['Faune', 'Flore'], true)) {
            throw $this->createNotFoundException("Categorie '$categorie' non prise en charge");
        }

        $cailloux = $caillouxRepository->findByCategorie($categorieNormalisee);

        return $this->render('Cailloux/index.html.twig', [
            'cailloux' => $cailloux,
            'categorie_active' => $categorieNormalisee,
        ]);
    }

}
