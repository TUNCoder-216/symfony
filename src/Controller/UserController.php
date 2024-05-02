<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use  Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Controller\DefaultController;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('base2.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/read', name: 'user_read')]
    public function read(ManagerRegistry $doctrine): Response
    {
        $user = $doctrine->getRepository(User::class)->findAll();
        return $this->render('user/read.html.twig',
            ["user" => $user]);
    }
    #[Route('/allusers', name: 'admin_read')]
    public function readAdmin(ManagerRegistry $doctrine): Response
    {
       
        $user = $this->userRepository->findAll();
        return $this->render('user/readAdmin.html.twig',
            ["user" => $user]);
    }

    #[Route('/edit', name: 'user_edit')]
    public function edit(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the updated user details to the database
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/deleteUser/{id}", name:'user_delete')]
    public function delete(User $user,EntityManagerInterface $em)
    {
        $em->remove($user);
        $em->flush();
    }


}
