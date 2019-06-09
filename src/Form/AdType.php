<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{
    public function formConfig($label, $placeholder) {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function formConfigRequired($label, $placeholder, $required) {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ],
            'required' => $required
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, 
                $this->formConfig('Titre', 'Titre de l\'annonce'))
            ->add('slug', TextType::class, 
                $this->formConfigRequired('Adresse web', '[Automatique] Adresse web de l\'annonce', false))
            ->add('price', MoneyType::class, 
                $this->formConfig('Prix','Prix à la nuit'))
            ->add('introduction', TextType::class, 
                $this->formConfig('Introduction','Texte mis en avant'))
            ->add('content', TextType::class, 
                $this->formConfig('Description','Description de l\'annonce'))
            ->add('coverImage', UrlType::class, 
                $this->formConfig('Image', 'Adresse de l\'image principale'))
            ->add('rooms', IntegerType::class, 
                $this->formConfig('Chambres','Nombre de chambres disponibles'))
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
