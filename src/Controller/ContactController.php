<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {
        // mise en place du formulaire pour le rendu dans la vue
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        // Hydratation du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash("success", "votre message à bien été envoyé.");
            return $this->redirectToRoute('contact');
        }
        // renvoie de la vue
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
