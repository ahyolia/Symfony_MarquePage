<?php

namespace App\Controller;

use App\Entity\MarquePage;
use App\Form\Type\MarquePageType;
use App\Repository\MarquePageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/ajout', name: 'ajout')]
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $marquepage = new MarquePage();
        $marquepage->setDateCreation(new \DateTime());

        $form = $this->createForm(MarquePageType::class, $marquepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($marquepage);
            $entityManager->flush();

            return $this->redirectToRoute('marquepage_ajout_succes');
        }

        $statusCode = $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK;

        return $this->render('MarquePage/ajout.html.twig', [
            'mon_formulaire' => $form->createView(),
        ], new Response(status: $statusCode));
    }

    #[Route('/modifier/{id<\d+>}', name: 'modifier')]
    public function modifier(int $id, Request $request, MarquePageRepository $marquePageRepository, EntityManagerInterface $entityManager): Response
    {
        $marquepage = $marquePageRepository->find($id);

        if (!$marquepage) {
            throw $this->createNotFoundException(sprintf('Marque-page avec l\'id %d introuvable.', $id));
        }

        $form = $this->createForm(MarquePageType::class, $marquepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('marquepage_details', ['id' => $marquepage->getId()]);
        }

        $statusCode = $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK;

        return $this->render('MarquePage/modifier.html.twig', [
            'mon_formulaire' => $form->createView(),
            'marquepage' => $marquepage,
        ], new Response(status: $statusCode));
    }

    #[Route('/ajout_succes', name: 'ajout_succes')]
    public function ajoutSucces(): Response
    {
        return $this->render('MarquePage/ajout_succes.html.twig');
    }

    


}

?>