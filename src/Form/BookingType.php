<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, [
                'label' => 'Date à d\'arrivée',
                'attr' => [
                    'placeholder' => 'Date à laquelle vous souhaitez arriver'
                ],
                'widget' => 'single_text'
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Date à de départ',
                'attr' => [
                    'placeholder' => 'Date à laquelle vous souhaitez partir'
                ],
                'widget' => 'single_text'
            ])
            ->add('comment', TextareaType::class, $this->formConfig(false, 'N\'hésitez pas si vous avez un commentaire'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
