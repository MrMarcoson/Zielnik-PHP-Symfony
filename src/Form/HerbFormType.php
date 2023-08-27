<?php

namespace App\Form;

use App\Entity\Herb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HerbFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('glagolitic')
            ->add('description')
            #->add('imagePath')
            #->add('recipes')
            ->add('properties')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Herb::class,
        ]);
    }
}
