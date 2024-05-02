<?php

namespace App\Controller;

use App\Entity\GestionCours;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistics')]
class StatisticsController extends AbstractController
{
    #[Route('/bibliotheque_usage', name: 'bibliotheque_usage_statistics')]
    public function bibliothequeUsage(EntityManagerInterface $entityManager): Response
    {
        // Fetch data from the database
        $repository = $entityManager->getRepository(GestionCours::class);
        $bibliothequeCounts = $repository->createQueryBuilder('g')
            ->select('b.id AS bibliotheque, COUNT(b.id) AS count')
            ->leftJoin('g.numero_biblio', 'b')
            ->groupBy('b.id')
            ->getQuery()
            ->getResult();

        // Format data for Chart.js
        $labels = [];
        $data = [];
        foreach ($bibliothequeCounts as $bibliothequeCount) {
            $labels[] = $bibliothequeCount['bibliotheque'];
            $data[] = $bibliothequeCount['count'];
        }

        // Render the template with the data
        return $this->render('statistics/bibliotheque_usage.html.twig', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
        ]);
    }
}