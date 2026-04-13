<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\Type\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auteur', name: 'auteur_')]
class AuteurAjoutController extends AbstractController
{
    #[Route('/ajout', name: 'ajout')]
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($auteur);
            $entityManager->flush();

            return $this->redirectToRoute('auteur_ajout_succes');
        }

        $statusCode = $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK;

        return $this->render('auteur/ajout.html.twig', [
            'mon_formulaire' => $form->createView(),
        ], new Response(status: $statusCode));
    }

    #[Route('/ajout_succes', name: 'ajout_succes')]
    public function ajoutSucces(): Response
    {
        return $this->render('auteur/ajout_succes.html.twig');
    }

    #[Route('/modifier/{id<\d+>}', name: 'modifier')]
    public function modifier(int $id, Request $request, AuteurRepository $auteurRepository, EntityManagerInterface $entityManager): Response
    {
        $auteur = $auteurRepository->find($id);

        if (!$auteur) {
            throw $this->createNotFoundException(sprintf('Auteur avec l\'id %d introuvable.', $id));
        }

        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('auteur_ajout_succes');
        }

        $statusCode = $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK;

        return $this->render('auteur/modifier.html.twig', [
            'mon_formulaire' => $form->createView(),
            'auteur' => $auteur,
        ], new Response(status: $statusCode));
    }
}
