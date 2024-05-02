<?php

namespace App\Form;

use App\Entity\GestionCours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType; 

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

// Importez FileType
use App\Entity\Bibliotheque;

class GestionCoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('numero_biblio', EntityType::class, [
            'class' => 'App\Entity\Bibliotheque',
            'choice_label' => 'id', // Or any other property you want to display
            'placeholder' => 'Select a Bibliotheque', // Optional placeholder
        ])
            ->add('titre')
            ->add('importer_pdf', FileType::class, [
                'label' => 'Importer un fichier PDF',
                'mapped' => false,
                'required' => false,
            ])
            ->add('nombre_pages')
            ->add('video', FileType::class, [
                'label' => 'Importer une vidéo',
                'mapped' => false,
                'required' => false,
            ]);
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GestionCours::class,
        ]);
    }
}
