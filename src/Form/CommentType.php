<?php

namespace App\Form;

use App\Entity\Comment;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating', IntegerType::class, [
                'label' => 'Note sur 5',
                'attr' => [
                    'placeholder' => 'La note que vous souhaitez attribuer',
                    'min' => 0,
                    'max' => 5,
                    'step' => 1
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre avis',
                'attr' => [
                    'placeholder' => 'Votre avis sur cette réservation'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
