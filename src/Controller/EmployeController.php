<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Employe;
use App\Form\Type\EmployeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/employe', name: 'employe_')]
class EmployeController extends AbstractController
{
    #[Route('/ajout', name: 'ajout')]
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $employe = new Employe();
        $employe->setAdresse(new Adresse());

        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employe);
            $entityManager->flush();

            return $this->redirectToRoute('employe_ajout_succes');
        }

        $statusCode = $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK;

        return $this->render('employe/ajout.html.twig', [
            'mon_formulaire' => $form->createView(),
        ], new Response(status: $statusCode));
    }

    #[Route('/ajout_succes', name: 'ajout_succes')]
    public function ajoutSucces(): Response
    {
        return $this->render('employe/ajout_succes.html.twig');
    }
}
