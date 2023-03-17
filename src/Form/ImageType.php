<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('imageName')
            ->add('updateAt', DateType::class, [
                'label' => 'Mis à jour le ',
                'widget' => 'single_text', 
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
            ])
            ->add('createAt', DateType::class, [
                'label' => 'Créer le  ',
                'widget' => 'single_text', 
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
            ])
            ->add('imageFile', FileType::class)
            // ->add('imageFile', FileType::class, [
            //     'label' => 'Image de plat (Des fichiers images uniquement)',
            //     // unmapped means that this field is not associated to any entity property
            //     'mapped' => false,
            //     // make it optional so you don't have to re-upload the PDF file
            //     // every time you edit the Product details
            //     'required' => false,
            //     // unmapped fields can't define their validation using annotations
            //     // in the associated entity, so you can use the PHP constraint classes
            //     'constraints' => [
            //         new File([
            //             'maxSize' => '1024k',
            //             'mimeTypes' => [
            //                 'image/jpeg',
            //                 'image/jpg',
            //             ],
            //             'mimeTypesMessage' => 'Please upload a valid image document',
            //         ])
            //     ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
