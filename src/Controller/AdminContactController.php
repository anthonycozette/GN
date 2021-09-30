<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminContactController extends AbstractController
{
    #[Route('/admin/contact', name: 'admin_contact')]
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('admin_contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    #[Route('/admin/contact/delete/{id}', name: 'delete-contact')]
    public function deleteContact(int $id, ContactRepository $contactRepository): Response
    {
        // on récupére un entity manager
        $em = $this->getDoctrine()->getManager();
        // on recupere le contact
        $contact = $contactRepository->find($id);
        // on supprime et on met a jour la bdd
        $em->remove($contact);
        $em->flush();
        // on redirige
        return $this->redirectToRoute("admin_contact");
    }
}
