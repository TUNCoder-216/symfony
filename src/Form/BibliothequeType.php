<?php

namespace App\Form;

use App\Entity\Bibliotheque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import EntityType
 // Import GestionCours entity

class BibliothequeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('numero_biblio')
            ->add('nom')
            ->add('specialite')
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false, // Set the image field as optional
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'image est obligatoire',
                    ]),
                ],
                'mapped' => false, // Important: tells Symfony not to try to map this field to an entity property
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bibliotheque::class,
        ]);
    }
}
