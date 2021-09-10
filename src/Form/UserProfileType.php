<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AvatarType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar', AvatarType::class, ["required"=>false])
            ->add('pseudo')
            ->add('nom')
            ->add('prenom')
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class, ["label"=>"changer le mot de passe", "required"=>false])
            ->add('adresse')
            ->add('codePostale')
            ->add('pays', CountryType::class)
            ->remove('roles')
            ->remove('isVerified');
            // ->add('Modifier', SubmitType::class, ['attr' => ["class" => "btn-success mt-3"]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
