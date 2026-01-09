<?php

namespace App\Form;

use App\Entity\Diplome;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Description',
                    'rows' => 3,
                ],
            ])
            ->add('avatar', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [new Image(['maxSize' => '5M'])],
                'attr' => [
                    'accept' => 'image/*',
                ],
            ])
            ->add('dateNais', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('diplomes', EntityType::class, [
                'class' => Diplome::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'label' => 'Diplômes & Certifications',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
