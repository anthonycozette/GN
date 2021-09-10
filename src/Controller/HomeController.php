<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\HomeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(HomeRepository $homeRepository, EvenementRepository $evenementRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'homeContent' => $homeRepository->findAll(),
            'evenement' => $evenementRepository->findBy([],["updatedAt"=>"DESC"],2)
        ]);
    }
}
