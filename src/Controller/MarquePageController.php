<?php

namespace App\Controller;

use App\Entity\MarquePage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class MarquePageController extends AbstractController
{
    #[Route('/MarquePage/page')]
    public function fct(EntityManagerInterface $entityManager): Response {

        $marquepages = $entityManager
            ->getRepository(MarquePage::class)
            ->findAll();
            
        return $this->render('MarquePage/page.html.twig', [
        'marquepages' => $marquepages,
    ]);
    }

}

?>