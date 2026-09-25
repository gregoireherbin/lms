<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Repository\CoursRepository; // ou ton repository de cours équivalent
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrontController extends AbstractController
{
    // ... tes autres méthodes ...

    #[Route('/cybercamp/etape/{id}', name: 'app_front_etape_show')]
    public function showEtape(Etape $etape): Response
    {
        return $this->render('front/etape_show.html.twig', [
            'etape' => $etape,
        ]);
    }
}