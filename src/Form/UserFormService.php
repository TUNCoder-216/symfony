<?php
namespace App\Form; 

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface; 
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFormService
{
    private $formFactory;
    private $entityManager;
    private $passwordEncoder;

    private $passwordHasher;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }
    public function createFormAndHandleRequest(Request $request): FormInterface
    {
        $newUser = new User();
        $form = $this->formFactory->create(UserType::class, $newUser);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            $confirmPassword = $form->get('password')->get('second')->getData();

        
            // Check if password and confirmPassword match
            if ($plainPassword !== $confirmPassword) {
                $form->get('password')->addError(new FormError('The password fields must match.'));
                return $form;
            }
        
            // Encode the password
            $hashedPassword = $this->passwordHasher->hashPassword($newUser, $plainPassword);
            $newUser->setPassword($hashedPassword);
        
            // Persist the user entity
            $this->entityManager->persist($newUser);
            $this->entityManager->flush();
        
            return $form;
        }
        
        return $form;
    }
    
    
} 
