<?php

namespace App\Form;

use App\Entity\Solution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SolutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenusolution')
            ->add('nomadmin')
            ->add('reclamation', EntityType::class, [
                'class' => 'App\Entity\Reclamation', // Replace with the correct class name of the Reclamation entity
                'choice_label' => 'id', 
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Solution::class,
        ]);
    }
}
