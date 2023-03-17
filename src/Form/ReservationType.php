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

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nombreCouvert', TextType::class, [
            'label' => 'Nombre de personne',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                ])
            ]])
            ->add('heure', TimeType::class, [
                'label' => 'Choisir une heure ',
                'widget' => 'single_text', 
            ])
            ->add('date', DateType::class, [
                'label' => 'Choisir une date ',
                'widget' => 'single_text', 
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
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
