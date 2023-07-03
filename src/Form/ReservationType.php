<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nombreCouvert', IntegerType::class, [
            'label' => 'Nombre de personne',
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                ])
            ]])
            ->add('date', DateType::class, [
                'label' => 'Choisir une date et une heure ',
                'widget' => 'single_text', 
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
            ])
            ->add('heure', TimeType::class, [
                'label' => false,
                'widget' => 'choice',
                'input' => 'datetime',
                'hours' => ['11', '12', '13', '18','19', '20', '21', '22'],
                'minutes' => range(0, 45, 15), // Sélection par tranche de 15 minutes
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide'
                    ])
                ]
            ])
            ->add('allergies')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
