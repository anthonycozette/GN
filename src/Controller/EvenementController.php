<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'evenement')]
    public function index(EvenementRepository $evenementRepository): Response
    {
        $evenements = $evenementRepository->findAll();
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    // #[Route('/evenement/{slug}', name: 'evenement')]
    // public function detail(evenementRepository $evenementRepository, int $slug): Response
    // {
    //     return $this->render('livre/detail.html.twig', [
    //         "evenement" => $evenementRepository->find($slug),
    //     ]);
    // }
}
