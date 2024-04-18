<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/back', name: 'app_admin')]
    public function indexadmin(): Response
    {
        return $this->render('user/indexadmin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/cours', name: 'app_coours')]
    public function indexadmin1(): Response
    {
        return $this->render('<templates>Cours.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
}


