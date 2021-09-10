<?php

namespace App\Controller;

use App\Form\UserProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        // mise en place du formulaire permetant la modification des information de l'utilisateurs
        $user = $this->getUser();
        $profileForm = $this->createForm(UserProfileType::class, $user);
        // on verifie la possibilite d'hydrater le formulaire avec des donnee se trouvant dans la requete
        $profileForm->handleRequest($request);
        // si on a pu hydrater le formulaire, on verifie si il est envoye et surtout valide
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $plainPassword = $profileForm->getData()->getPlainPassword();
            if (!is_null($plainPassword)) {
                $encodedPassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);
                $user->setPassword($encodedPassword);
                $this->addFlash('warning', "votre mot de passe a bien été changé.");
            }
            // on recupere une entite manager pour pouvoir gerer la mise en base de donnees
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            // on met en place un flashMessage
            $this->addFlash('success', "Vos information on bien été mise a jour.");
            // on redirige sur la route profile ce qui permet a symfony de supprimer les message lorsqu'il on été afficher per la twig, sinon il reste en memoire ainsi que les information du formulaire de l'utilisateur se trouvant dans la request de sorte que si l'on recharge la page, les modife sont continuellement refaites et les alerte affichées
            return $this->redirectToRoute("profile");
        }
        return $this->render('profile/index.html.twig', [
            "form" => $profileForm->createView(), // on passe a la vue le rendu du formulaire
        ]);
    }
}
