<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Knp\Component\Pager\PaginatorInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Controller\UrlGeneratorInterface ;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
#[Route('/reclamation')]
class ReclamationController extends AbstractController
{



    public function index(Request $request, ReclamationRepository $reclamationRepository, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('q');
    
        $query = $reclamationRepository->createQueryBuilder('r');
    
        // Si un terme de recherche est spécifié, ajoutez des conditions de recherche à la requête
        if ($searchTerm) {
            $query->where('r.contenu LIKE :searchTerm')
                  ->orWhere('r.mail LIKE :searchTerm')
                  ->orWhere('r.type LIKE :searchTerm')
                  ->orWhere('r.etat LIKE :searchTerm')
                  ->orWhere('r.telephone LIKE :searchTerm')
                  ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
    
        $query = $query->getQuery();
    
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Obtenez le numéro de page à partir de la requête, sinon 1 par défaut
            5 // Nombre d'éléments par page
        );
    
        // Récupérer la langue sélectionnée
        $targetLanguage = $request->query->get('lang', 'fr'); // Par défaut, la langue est le français
    
        // Traduire le contenu des réclamations
        $translator = new GoogleTranslate();
        $translator->setSource('auto'); // Détection automatique de la langue source
        $translator->setTarget($targetLanguage); // Langue cible
    
        // Traduire le contenu de chaque réclamation
        foreach ($pagination as $reclamation) {
            $reclamation->setContenu($translator->translate($reclamation->getContenu()));
            // Traduisez d'autres champs si nécessaire
        }
    
        // Compter le nombre de réclamations traitées
        $reclamationsTraitees = $reclamationRepository->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->where('r.etat = :etat')
            ->setParameter('etat', 'Traité')
            ->getQuery()
            ->getSingleScalarResult();
    
        return $this->render('reclamation/index.html.twig', [
            'pagination' => $pagination,
            'searchTerm' => $searchTerm, // Passer le terme de recherche à la vue
            'reclamationsTraitees' => $reclamationsTraitees, // Passer le nombre de réclamations traitées à la vue
        ]);
    }
    



   


    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer le téléchargement de l'image
            $photo = $request->files->get('photo');
    
            if ($photo instanceof UploadedFile) {
                $destinationDirectory = 'C:\Users\ousam\Desktop\web\symfony';
                $fileName = '1.jpg';
                try {
                    // Déplacez le fichier vers le répertoire spécifié
                    $photo->move($destinationDirectory, $fileName);
                } catch (FileException $e) {
                    // Gérer les erreurs de téléchargement de fichier
                    // Vous pouvez rediriger l'utilisateur vers le formulaire avec un message d'erreur
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'enregistrement de l\'image.');
                    return $this->redirectToRoute('app_reclamation_new');
                }
            }
    
            // Charger les mots interdits depuis le fichier
            $forbiddenWords = file('C:\Users\ousam\Desktop\interdit.txt', FILE_IGNORE_NEW_LINES);
            if ($forbiddenWords === false) {
                // Gérer les erreurs de chargement du fichier
                // Vous pouvez rediriger l'utilisateur vers le formulaire avec un message d'erreur
                $this->addFlash('error', 'Une erreur est survenue lors du chargement des mots interdits.');
                return $this->redirectToRoute('app_reclamation_new');
            }
    
            // Filtrer les mots interdits dans le contenu de la réclamation
            $filteredContent = str_replace($forbiddenWords, '*', $reclamation->getContenu());
            $reclamation->setContenu($filteredContent);
    
            // Enregistrez les autres données du formulaire dans la base de données si nécessaire
            $entityManager->persist($reclamation);
            $entityManager->flush();
    
            // Redirigez l'utilisateur vers la page d'index après une soumission réussie
            $this->addFlash('success', 'La réclamation a été enregistrée avec succès.');
            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }






    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/statistics', name: 'app_reclamation_statistics', methods: ['GET'])]
    public function statistics(ReclamationRepository $reclamationRepository): Response
    {
        // Récupérer le nombre total de réclamations
        $totalReclamations = $reclamationRepository->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->getQuery()
            ->getSingleScalarResult();

        // Récupérer le nombre de réclamations traitées
        $reclamationsTraitees = $reclamationRepository->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->where('r.etat = :etat')
            ->setParameter('etat', 'Traité')
            ->getQuery()
            ->getSingleScalarResult();

        // Calculer le nombre de réclamations non traitées
        $reclamationsNonTraitees = $totalReclamations - $reclamationsTraitees;

        return $this->render('reclamation/statistics.html.twig', [
            'totalReclamations' => $totalReclamations,
            'reclamationsTraitees' => $reclamationsTraitees,
            'reclamationsNonTraitees' => $reclamationsNonTraitees,
        ]);
    }



}
