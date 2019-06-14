<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, $this->formConfig('Prénom', 'Votre prénom'))
            ->add('lastname', TextType::class, $this->formConfig('Nom', 'Votre nom'))
            ->add('email', EmailType::class, $this->formConfig('Email', 'Votre email'))
            ->add('picture', UrlType::class, $this->formConfig('Image de profil', 'Votre image de profil'))
            ->add('hash', PasswordType::class, $this->formConfig('Mot de passe', 'Votre mot de passe'))
            ->add('confirmPassword', PasswordType::class, $this->formConfig('Confirmation du mot de passe', 'Veuillez confirmer votre mot de passe'))
            ->add('introduction', TextType::class, $this->formConfig('Introduction', 'Rapide présentation'))
            ->add('description', TextareaType::class, $this->formConfig('Description détaillée', 'Présentation détaillée de vous'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
