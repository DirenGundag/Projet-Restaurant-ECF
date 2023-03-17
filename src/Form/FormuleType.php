<?php

namespace App\Form;

use App\Entity\Formule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Validator\Constraints\NotBlank;


class FormuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
            'label' => 'Description',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                    ])
            ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                    ])
            ]
            ])
            ->add('menu')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formule::class,
        ]);
    }
}
