<?php

namespace App\Controller;

use App\Entity\Bibliotheque;
use App\Form\BibliothequeType;
use App\Repository\BibliothequeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/bibliotheque')]
class BibliothequeController extends AbstractController
{
    /* /**
     * @Route("/Courss", name="app_cours")
     
    public function coursPage(): Response
    {
        // Récupérer les données depuis la base de données ou autre source
        $bibliotheques = $this->getDoctrine()->getRepository(Bibliotheque::class)->findAll();
    
        // Renvoyer le contenu du fichier Cours.html.twig avec les données passées en paramètre
        return $this->render('Cours.html.twig', [
            'bibliotheques' => $bibliotheques,
        ]);
    }*/
    
    #[Route('/', name: 'app_bibliotheque_index', methods: ['GET'])]
    public function index(BibliothequeRepository $bibliothequeRepository): Response
    {
        return $this->render('bibliotheque/index.html.twig', [
            'bibliotheques' => $bibliothequeRepository->findAll(),
        ]);
    }
    
    #[Route('/new', name: 'app_bibliotheque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bibliotheque = new Bibliotheque();
        $form = $this->createForm(BibliothequeType::class, $bibliotheque);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier image soumis
            $imageFile = $form->get('image')->getData();
    
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('app_produit_new');
                }
    
                $bibliotheque->setImage($newFilename);
            }
    
            $entityManager->persist($bibliotheque);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_bibliotheque_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('bibliotheque/new.html.twig', [
            'bibliotheque' => $bibliotheque,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_bibliotheque_show', methods: ['GET'])]
    public function show(Bibliotheque $bibliotheque): Response
    {
        return $this->render('bibliotheque/show.html.twig', [
            'bibliotheque' => $bibliotheque,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bibliotheque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bibliotheque $bibliotheque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BibliothequeType::class, $bibliotheque);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérez l'exception si le déplacement du fichier échoue
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('app_produit_edit', ['id' => $bibliotheque->getId()]);
                }

                // Mettez à jour le champ 'image' seulement si une nouvelle image est téléchargée
                $bibliotheque->setImage($newFilename);
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bibliotheque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bibliotheque/edit.html.twig', [
            'bibliotheque' => $bibliotheque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bibliotheque_delete', methods: ['POST'])]
    public function delete(Request $request, Bibliotheque $bibliotheque, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bibliotheque->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bibliotheque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bibliotheque_index', [], Response::HTTP_SEE_OTHER);
    }
}
