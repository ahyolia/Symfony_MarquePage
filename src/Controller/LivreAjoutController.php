<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\Type\LivreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/livres', name: 'livres_')]
class LivreAjoutController extends AbstractController
{
    #[Route('/ajout', name: 'ajout')]
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livres();
        $form = $this->createForm(LivreType::class, $livre, [
            'include_auteur' => true,
            'require_consent' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $anneeSaisie = $form->get('annee_saisie')->getData();
            if ($anneeSaisie !== null && $anneeSaisie !== '') {
                $livre->setAnnee(new \DateTime(sprintf('%04d-01-01', (int) $anneeSaisie)));
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livres_ajout_succes');
        }

        $statusCode = $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK;

        return $this->render('Livres/ajout.html.twig', [
            'mon_formulaire' => $form->createView(),
        ], new Response(status: $statusCode));
    }

    #[Route('/ajout_succes', name: 'ajout_succes')]
    public function ajoutSucces(): Response
    {
        return $this->render('Livres/ajout_succes.html.twig');
    }

    #[Route('/modifier/{id<\d+>}', name: 'modifier')]
    public function modifier(Request $request, Livres $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre, [
            'annee_initiale' => $livre->getAnnee()?->format('Y'),
            'include_auteur' => false,
            'require_consent' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $anneeSaisie = $form->get('annee_saisie')->getData();
            if ($anneeSaisie !== null && $anneeSaisie !== '') {
                $livre->setAnnee(new \DateTime(sprintf('%04d-01-01', (int) $anneeSaisie)));
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('livres_ajout_succes');
        }

        $statusCode = $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK;

        return $this->render('Livres/modifier.html.twig', [
            'mon_formulaire' => $form->createView(),
            'livre' => $livre,
        ], new Response(status: $statusCode));
    }
}
