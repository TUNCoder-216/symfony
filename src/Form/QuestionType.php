<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('questiontext', TextType::class, [
                'attr' => ['placeholder' => 'Enter question..'],
                'constraints' => [
                    new NotBlank(['message' => 'empty field .']),
                    new Regex([
                        'pattern' => '/\d/', // Disallow numbers
                        'match' => false,
                        'message' => 'Numbers are not allowed in this field.',
                    ]),
                ],
            ])
            ->add('optiona', TextType::class, [
                'attr' => ['placeholder' => 'Enter option..'],
                'constraints' => [
                    new NotBlank(['message' => 'empty field .']),
                    new Regex([
                        'pattern' => '/\d/', // Disallow numbers
                        'match' => false,
                        'message' => 'Numbers are not allowed in this field.',
                    ]),
                ],
            ])
            ->add('optionb', TextType::class, [
                'attr' => ['placeholder' => 'Enter option..'],
                'constraints' => [
                    new NotBlank(['message' => 'empty field .']),
                    new Regex([
                        'pattern' => '/\d/', // Disallow numbers
                        'match' => false,
                        'message' => 'Numbers are not allowed in this field.',
                    ]),
                ],
            ])
            ->add('optionc', TextType::class, [
                'attr' => ['placeholder' => 'Enter option..'],
                'constraints' => [
                    new NotBlank(['message' => 'empty field .']),
                    new Regex([
                        'pattern' => '/\d/', // Disallow numbers
                        'match' => false,
                        'message' => 'Numbers are not allowed in this field.',
                    ]),
                ],
            ])
            ->add('correctoptionindex', NumberType::class, [
                'attr' => ['placeholder' => 'Enter right answer..'],
                'constraints' => [
                    new NotBlank(['message' => 'Empty field.']),
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Please enter a valid number.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 3,
                        'minMessage' => 'Duration must be at least 1.',
                        'maxMessage' => 'Duration cannot be more than 3.',
                    ]),
                ],
            ])
            ->add('quiz')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
