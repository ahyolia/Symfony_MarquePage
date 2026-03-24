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


    #[Route("/ajouter", name: "ajouter")]
    public function ajouter(EntityManagerInterface $entityManager) : Response {
        // Creation d'un auteur puis d'un livre associe
        $cailloux = new Cailloux();
        $cailloux->setTitre("Cagou");
        $cailloux->setDescription("Le cagou est un oiseau endémique de Nouvelle-Calédonie, connu pour son plumage gris et son incapacité à voler.");
        $cailloux->setCategorie("Faune");
        $cailloux->setImages("cagou.jpg");
        $entityManager->persist($cailloux); 

        $cailloux2 = new Cailloux();
        $cailloux2->setTitre("Trico-rayé");
        $cailloux2->setDescription("Le trico-rayé est un oiseau endémique de Nouvelle-Calédonie, reconnaissable à son plumage rayé noir et blanc.");
        $cailloux2->setCategorie("Faune");
        $cailloux2->setImages("trico_raye.jpg");
        $entityManager->persist($cailloux2);

        $cailloux3 = new Cailloux();
        $cailloux3->setTitre("Niaouli");
        $cailloux3->setDescription("Le niaouli est un arbre endémique de Nouvelle-Calédonie, apprécié pour son bois et ses propriétés médicinales.");
        $cailloux3->setCategorie("Flore");
        $cailloux3->setImages("niaouli.jpg");
        $entityManager->persist($cailloux3);

        $cailloux4 = new Cailloux();
        $cailloux4->setTitre("Hibiscus de Nouvelle-Calédonie");
        $cailloux4->setDescription("L'hibiscus de Nouvelle-Calédonie est une plante endémique, célèbre pour ses grandes fleurs colorées.");
        $cailloux4->setCategorie("Flore");
        $cailloux4->setImages("hibiscus.jpg");
        $entityManager->persist($cailloux4);

        $entityManager->flush();
        return new Response("Eléments ajoutés avec succès !");


    }
}
