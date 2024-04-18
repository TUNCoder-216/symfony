<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\UserFormService;

class TestController extends AbstractController
{
    private $userFormService;

    public function __construct(UserFormService $userFormService)
    {
        $this->userFormService = $userFormService;
    }

    /**
     * @Route("/Loader/{page_path}", name="app_test")
     */
    public function index($page_path, Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $file_path = "user/".$page_path;

        if ($page_path === 'newacc.html.twig') {
            // Create the form
            $formOrSuccess = $this->userFormService->createFormAndHandleRequest($request);

            if ($formOrSuccess instanceof \Symfony\Component\Form\FormInterface) {
                // Form submission failed, render the form with errors
                return $this->render($file_path, [
                    'form' => $formOrSuccess->createView(),
                ]);
            } elseif (isset($formOrSuccess['success']) && $formOrSuccess['success']) {
                // Success: Redirect or show a success message
                $this->addFlash('success', 'User created successfully.');
                return $this->redirectToRoute('success_route');
            }
        } elseif ($page_path === 'login.html.twig') {
            // Get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();

            // Last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render($file_path, [
                'last_username' => $lastUsername,
                'error' => $error,
            ]);
        } elseif (file_exists($this->getParameter('kernel.project_dir').'/templates/'.$file_path)) {
            return $this->render($file_path, []);
        }

        // Page not found
        return $this->render('user/404.html', []);
    }
}
