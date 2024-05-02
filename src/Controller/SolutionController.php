<?php

namespace App\Controller;

use App\Entity\Solution;
use App\Form\SolutionType;
use App\Repository\SolutionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
#[Route('/solution')]
class SolutionController extends AbstractController
{
    #[Route('/', name: 'app_solution_index', methods: ['GET', 'POST'])]
    public function index(SolutionRepository $solutionRepository, Request $request): Response
    {
        $contenusolution = $request->query->get('contenusolution');
    
        if ($contenusolution) {
            $solutions = $solutionRepository->searchByContenusolution($contenusolution);
        } else {
            $solutions = $solutionRepository->findAll();
        }
    
        return $this->render('solution/index.html.twig', [
            'solutions' => $solutions,
        ]);
    }

    #[Route('/newSolution', name: 'app_solution_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $solution = new Solution();
        $form = $this->createForm(SolutionType::class, $solution);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($solution);
            $entityManager->flush();
            
            // Vérifiez s'il y a une réclamation associée à la solution
            $reclamation = $solution->getReclamation();
    
            if ($reclamation) {
                $reclamationId = $reclamation->getId();
    
                // Si la réclamation est trouvée, mettez à jour son état
                $reclamation->setEtat('Traité');
                $entityManager->flush();
    
                $email = $reclamation->getMail();
            
                // Vérifier si l'adresse e-mail est définie
                if ($email) {
                    $emailContent = "
                        <html>
                            <body style='background-color: green;'>
                                <h1>Votre réclamation a été soumise avec succès!</h1>
                                <p>Voici le contenu de votre réclamation : " . $reclamation->getContenu() . "</p>
                                
                                <style>
                                    p {
                                        color: blue;
                                    }
                                </style>
                            </body>
                        </html>
                    ";
            
                    // Créer l'e-mail avec le contenu HTML
                    $email = (new Email())
                        ->from('ousamaaaa@gmail.com') // Remplacez par votre adresse e-mail
                        ->to($email) // Utilisez l'adresse e-mail de la réclamation
                        ->subject('Nouvelle réclamation soumise')
                        ->html($emailContent); // Contenu de l'e-mail au format HTML
            
                    // Ajouter la photo en tant que pièce jointe et définir son identifiant pour l'inclure dans le contenu HTML
                    $email->embedFromPath('C:\Users\ousam\Desktop\web\symfony\public\img\test.png', 'photo');
        
                    // Envoyer l'e-mail
                    $mailer->send($email);
                }
    
                return $this->redirectToRoute('app_solution_index', [], Response::HTTP_SEE_OTHER);
            }
        }
    
        return $this->renderForm('solution/new.html.twig', [
            'solution' => $solution,
            'form' => $form,
        ]);
    }
    








    #[Route('/{id}', name: 'app_solution_show', methods: ['GET'])]
    public function show(Solution $solution): Response
    {
        return $this->render('solution/show.html.twig', [
            'solution' => $solution,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_solution_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Solution $solution, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SolutionType::class, $solution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_solution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('solution/edit.html.twig', [
            'solution' => $solution,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_solution_delete', methods: ['POST'])]
    public function delete(Request $request, Solution $solution, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$solution->getId(), $request->request->get('_token'))) {
            $entityManager->remove($solution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_solution_index', [], Response::HTTP_SEE_OTHER);
    }










}
