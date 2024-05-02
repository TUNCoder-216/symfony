<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
 use  Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('baseAdmin.html.twig', [
            'controller_name' => 'AdminController',
        ]); 
    }

    #[Route('/ajouter', name: 'admin_add')]
    public function ajouter(ManagerRegistry $doctrine, Request  $request) : Response
    { 
        $admin = new Admin() ;
        $form = $this->createForm(AdminType::class, $admin);
        $form->add('ajouter', SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
           
                $imageFile = $form->get('imageAdmin')->getData();
        
                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
        
                    try {
                        $imageFile->move(
                            $this->getParameter('image_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // handle exception
                    }
        
                    $admin->setImageAdmin($newFilename);
                }
            
            
            $em = $doctrine->getManager();
            $em->persist($admin);
            $em->flush();
            return $this->redirectToRoute('admin_read');
        }
        return $this->renderForm("admin/addA.html.twig",
            ["f"=>$form]) ;


    }
    #[Route('/all', name: 'admin_read_read')]
    public function read(ManagerRegistry $doctrine): Response
    {
        $admin = $doctrine->getRepository(Admin::class)->findAll();
        return $this->render('admin/readAdmin.html.twig',
            ["admin" => $admin]);
    }





    #[Route('/update/{id}', name: 'admin_update')]
    public function update(Request $request, ManagerRegistry $doctrine,$id): Response
    { $admin= $doctrine->getRepository(Admin::class)->find($id);
        $form = $this->createForm(AdminType::class, $admin);
        $form->add('update', SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
           
            $imageFile = $form->get('imageAdmin')->getData();
    
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }
    
                $admin->setImageAdmin($newFilename);
            }
             $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('admin_read');
        }
        return $this->renderForm("admin/updateAdmin.html.twig",
            ["f"=>$form]) ;

    }
    #[Route("/deleteAdmin/{id}", name:'admin_delete')]
    public function deleteAdmin($id, ManagerRegistry $doctrine)
    {
        $a= $doctrine
        ->getRepository(Admin::class)
        ->find($id);
        $em = $doctrine->getManager();
        $em->remove($a);
        $em->flush() ;
        return $this->redirectToRoute('admin_read');
    }


}
