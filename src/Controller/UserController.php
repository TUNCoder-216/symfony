<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user3')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/admin1', name: 'app_user1')]
    public function index1(): Response
    {
        return $this->render('user/indexadmin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/user/new", name="user_new")
     */
    public function createUser(Request $request): Response
    {
        // Create the form
        $form = $this->createFormAndHandleRequest($request);

        // Render the form template
        return $this->render('user/newacc.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function createFormAndHandleRequest(Request $request)
    {
        // Create a new user entity
        $newUser = new User();
        
        // Create the user form
        $form = $this->createForm(UserType::class, $newUser);
        
        // Handle the form submission
        $form->handleRequest($request);
        
        // If the form is submitted and valid, persist the user to the database
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newUser);
            $entityManager->flush();
        }
        
        return $form;
    }

    /**
     * @Route("/user/getAll", name="user_listDB")
     */
    public function getAll(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/showusers.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/user/{id}/update", name="user_update")
     */
    public function updateUser(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, $id): Response
    {
        // Fetch the user by ID
        $user = $userRepository->find($id);

        // Create the form
        $form = $this->createForm(UserType::class, $user);

        // Handle form submission
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the updated user entity
            $entityManager->flush();

            // Redirect to the user list or any other page
            return $this->redirectToRoute('user_listDB');
        }

        // Render the update form template
        return $this->render('user/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
     /**
     * @Route("/user/delete/{id}", name="user_delete")
     */
    public function deleteUser($id, EntityManagerInterface $entityManager): Response
    {
        // Get the user from the database
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($id);

        // If user not found, return error response
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Remove the user from the database
        $entityManager->remove($user);
        $entityManager->flush();

        // Redirect to some route after successful deletion
        return $this->redirectToRoute('user_listDB');
    }
}

