<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\CoursRepository;
use App\Repository\EtapeRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index()
    {
        return $this->render('home.html.twig');
    }

    #[Route('/utilisateurs', name: 'app_users')]
    public function users(UserRepository $users)
    {
        return $this->render('users.html.twig',[
            'users'=>$users->findAll()
        ]);
    }

    #[Route('/cours', name: 'app_cours')]
    public function cours(CoursRepository $cours)
    {
        return $this->render('cours.html.twig',[
            'cours'=>$cours->findAll()
        ]);
    }

    #[Route('/etapes', name: 'app_etapes')]
    public function etapes(EtapeRepository $etapes)
    {
        return $this->render('etapes.html.twig',[
            'etapes'=>$etapes->findAll()
        ]);
    }
}
