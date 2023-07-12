<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Piece;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pceName', TextType::class, ['label'=> 'Nom de la pièce'])
            ->add('pceColor', TextType::class, ['label'=>'Couleur'])
            ->add('pcePrice', TextType::class, ['label'=>'Prix TTC'])
            ->add('images', FileType::class, array('data_class'=>null, 'mapped'=>false, 'required'=>false, 'label'=>'Photo', 'multiple'=>true))
            ->add('pceCategory', EntityType::class, ['class'=>Category::class, 'choice_label'=>'catNaming'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
        ]);
    }
}
