<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
    
        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($this->getUser()) {
            return $this->redirectToRoute('app_user'); // Change 'app_dashboard' to your actual dashboard route
        }
        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
    
    public function logout()
    {
        // The logout action is handled automatically by Symfony's security system
        // You don't need to implement anything here
    }
}
