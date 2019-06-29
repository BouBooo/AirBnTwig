<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    private $transformer;

    public function __construct(FrenchToDateTimeTransformer $transformer) {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', TextType::class, [
                'label' => 'Date à d\'arrivée',
                'attr' => [
                    'placeholder' => 'Date à laquelle vous souhaitez arriver'
                ]
            ])
            ->add('endDate', TextType::class, [
                'label' => 'Date à de départ',
                'attr' => [
                    'placeholder' => 'Date à laquelle vous souhaitez partir'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ce message sera visible par le propriétaire de l\'annonce'
                ],
                'required' => false
            ])
        ;

        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
