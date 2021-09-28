<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Evenement;
use App\Form\CommentaireType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/evenement/{slug}', name: 'evenement-detail', methods: ['GET', 'POST'])]
    public function detail(EvenementRepository $evenementRepository, int $slug, Request $request, EntityManagerInterface $em): Response
    {
        $evenement = $evenementRepository->find($slug);
        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setEvenement($evenement);
            $commentaire->setAuteur($this->getUser());

            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('evenement-detail', ['slug' => $slug]);
        }


        return $this->render('evenement/detail.html.twig', [
            "evenement" => $evenementRepository->find($slug),
            'form' => $form->createView()
        ]);
    }
}
