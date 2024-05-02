<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['placeholder' => 'Enter quiz name..'],
                'constraints' => [
                    new NotBlank(['message' => 'empty field .']),
                    new Regex([
                        'pattern' => '/\d/', // Disallow numbers
                        'match' => false,
                        'message' => 'Numbers are not allowed in this field.',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'attr' => ['placeholder' => 'Enter quiz description..'],
                'constraints' => [
                    new NotBlank(['message' => 'empty field .']),
                    new Regex([
                        'pattern' => '/\d/', // Disallow numbers
                        'match' => false,
                        'message' => 'Numbers are not allowed in this field.',
                    ]),
                ],
            ])
            ->add('difficulte', TextType::class, [
                'attr' => ['placeholder' => 'Enter quiz difficulty..'],
                'constraints' => [
                    new NotBlank(['message' => 'empty field .']),
                ],
            ])
            ->add('durationmin', NumberType::class, [
                'attr' => ['placeholder' => 'Enter quiz duration..'],
                'constraints' => [
                    new NotBlank(['message' => 'Empty field.']),
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Please enter a valid number for the duration.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 120,
                        'minMessage' => 'Duration must be at least {{ limit }}.',
                        'maxMessage' => 'Duration cannot be more than {{ limit }}.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
