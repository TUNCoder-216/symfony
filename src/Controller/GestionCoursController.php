<?php

namespace App\Controller;

use App\Entity\GestionCours;
use App\Form\GestionCoursType;
use App\Repository\GestionCoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;

use Symfony\Component\HttpFoundation\File\File;


#[Route('/gestion/cours')]
class GestionCoursController extends AbstractController
{
     /**
     * @Route("/Courss", name="app_cours")
     */
    public function coursPage(): Response
    {
        // Récupérer les données depuis la base de données ou autre source
        $gestion_cours = $this->getDoctrine()->getRepository(GestionCours::class)->findAll();

        // Renvoyer le contenu du fichier Cours.html.twig avec les données passées en paramètre
        return $this->render('Cours.html.twig', [
            'gestion_cours' => $gestion_cours,
        ]);
    }
    #[Route('/pdf/{id}', name: 'app_gestion_cours_pdf')]
public function viewPdf(int $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $gestionCours = $entityManager->getRepository(GestionCours::class)->find($id);

    if (!$gestionCours) {
        throw $this->createNotFoundException('Le cours que vous cherchez n\'existe pas.');
    }

    $pdfPath = $this->getParameter('dossier_pdf') . '/' . $gestionCours->getPdf();

    // Créer une instance de la classe File pour le PDF
    $pdfFile = new File($pdfPath);

    // Renvoyer le PDF en réponse
    return $this->file($pdfFile);
}
    #[Route('/', name: 'app_gestion_cours_index', methods: ['GET'])]
    public function index(GestionCoursRepository $gestionCoursRepository): Response
    {
        return $this->render('gestion_cours/index.html.twig', [
            'gestion_cours' => $gestionCoursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gestion_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gestionCours = new GestionCours();
        $form = $this->createForm(GestionCoursType::class, $gestionCours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichierPdf = $form->get('importer_pdf')->getData();
            $fichierVideo = $form->get('video')->getData();

            if ($fichierPdf) {
                $nomFichier = md5(uniqid()) . '.' . $fichierPdf->guessExtension();
                $fichierPdf->move($this->getParameter('dossier_pdf'), $nomFichier);
                $gestionCours->setPdf($nomFichier);
            }

            if ($fichierVideo) {
                $dossierVideoPath = $this->getParameter('dossier_video');
                $nomFichierVideo = md5(uniqid()) . '.' . $fichierVideo->guessExtension();
                $fichierVideo->move($dossierVideoPath, $nomFichierVideo);
                $gestionCours->setVideo($nomFichierVideo);
            }

            // Vérifiez si le fichier PDF et le fichier vidéo existent
            if ($gestionCours->getPdf() !== null && $gestionCours->getVideo() !== null) {
                $entityManager->persist($gestionCours);
                $entityManager->flush();

                return $this->redirectToRoute('app_gestion_cours_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('gestion_cours/new.html.twig', [
            'gestion_cours' => $gestionCours,
            'form' => $form->createView(),
        ]);
    }
    


    #[Route('/{id}', name: 'app_gestion_cours_show', methods: ['GET'])]
    public function show(GestionCours $gestionCour): Response
    {
        return $this->render('gestion_cours/show.html.twig', [
            'gestion_cour' => $gestionCour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gestion_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GestionCours $gestionCour, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(GestionCoursType::class, $gestionCour);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $fichierPdf = $form->get('importer_pdf')->getData();
        $fichierVideo = $form->get('video')->getData();

        if ($fichierPdf) {
            // Code pour traiter et stocker le fichier PDF
        }

        if ($fichierVideo) {
            $nomFichierVideo = md5(uniqid()).'.'.$fichierVideo->guessExtension();
            $fichierVideo->move(
                $this->getParameter('dossier_video'),
                $nomFichierVideo
            );
            $gestionCour->setVideo($nomFichierVideo);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_gestion_cours_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('gestion_cours/edit.html.twig', [
        'gestion_cour' => $gestionCour,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_gestion_cours_delete', methods: ['POST'])]
    public function delete(Request $request, GestionCours $gestionCour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gestionCour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($gestionCour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gestion_cours_index', [], Response::HTTP_SEE_OTHER);
 
    }
    public function generatePdf(GestionCoursRepository $gestionCourRepository): Response
    {
        // Récupérez la liste des clubs depuis le repository
        $gestion_cours = $gestionCourRepository->findAll();
    
        // Créez une instance de Dompdf
        $dompdf = new Dompdf();
    
        // Générez le contenu HTML pour le PDF
        $htmlContent = $this->renderView('gestion_cours/pdf.html.twig', [
            'gestion_cours' =>$gestion_cours,
        ]);
    
        // Chargez le contenu HTML dans Dompdf
        $dompdf->loadHtml($htmlContent);
    
        // Réglez les options de Dompdf si nécessaire
        $dompdf->setPaper('A4', 'portrait');
    
        // Rendu du PDF
        $dompdf->render();
    
        // Obtenez le contenu PDF généré
        $pdfContent = $dompdf->output();
    
        // Créez une réponse Symfony pour retourner le PDF au navigateur
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
    
        // Facultatif : téléchargement du PDF au lieu de l'afficher dans le navigateur
        // $response->headers->set('Content-Disposition', 'attachment; filename="liste_clubs.pdf"');
    
        return $response;
    }
}
