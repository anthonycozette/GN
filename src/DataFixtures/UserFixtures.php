<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    // on declare une propriété (privée parce qu'elle ne concerne que la fixture) qui va nous permettre d'accéder au UserPasswordHasherInterface partout dans les methodes de la classe
    private $encoder;
    /**
     * on met en place un constructeur afin de pouvoir injecter le UserPasswordHasherInterface dans la classe
     * et pouvoir l'utiliser notamment dans la methode load (methode native dans laquelle on ne peut pas faire l'injection)
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        // on memorise le UserPasswordHasherInterface injecte dans la propriete de classe de sorte qu'on y aura acces depuis toutes les methodes de classe
        $this->encoder = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {
        // ADMIN USER
        // on instancie un utilisateur
        $user = new User();
        // on renseigne la propriete email a l'aide du setter
        $user->setEmail('admin@admin.com');
        // gestion du mot de passe
        $plainPassword = "pass"; // le mot de passe en clair que l'on veut encoder
        $encodePassword = $this->encoder->hashPassword($user, $plainPassword); // on encode le password avec l'encoder memoriser lors de l'injection dans le constructeur
        $user->setPassword($encodePassword); // on renseigne la propriete password de l'utilisateur avec le setter
        $user->setRoles(["ROLE_USER", "ROLE_ADMIN"]); // on affecte un role a l'utilisateur
        // on memorise l'instance d'utilisateur afin de l'ajouter ulterieurement dans la base de donnees
        $manager->persist($user);

        //SIMPLE USER
        $user = new User();
        $user->setEmail('user@user.com');
        $plainPassword = "pass";
        $encodePassword = $this->encoder->hashPassword($user, $plainPassword);
        $user->setPassword($encodePassword);
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        $manager->flush();
    }
}
