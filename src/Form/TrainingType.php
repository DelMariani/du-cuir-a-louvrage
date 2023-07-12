<?php

namespace App\Form;

use App\Entity\Training;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('trainTitled', TextType::class, ['label'=> 'Nom de la formation'])
            ->add('trainTopic', TextType::class, ['label'=> 'Thème'])
            ->add('trainDate', DateTimeType::class, [ 'widget' => 'single_text', 'html5'=> false, 'format' => 'dd-MM-yyyy',
                'input' => 'datetime_immutable', 'label'=>'Date'])
            ->add('trainSeat', TextType::class, ['label'=>'Nombre de places'] )
            ->add('trainPlace', TextType::class, ['label'=> 'Lieu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }
}
