<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, ['label'=> 'Votre Prénom', 'attr'=>['class'=> 'form-label form-control w-75']])
            ->add('nom', TextType::class, ['label'=> 'Votre Nom', 'attr'=>['class'=> 'form-label form-control w-75']])
            ->add('telephone', TelType::class, ['label' => 'Numéro de téléphone', 'attr'=>['class'=> 'form-label form-control w-75']])
            ->add('email', EmailType::class, ['label'=> 'Adresse e-mail', 'attr'=>['class'=> 'form-label form-control w-100']])
            ->add('content', TextareaType::class, ['label'=>'Votre message', 'attr'=>['class'=> 'form-label form-control w-100 ']])

        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
