<?php

namespace App\Repository;

use App\Entity\GestionCours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GestionCours>
 *
 * @method GestionCours|null find($id, $lockMode = null, $lockVersion = null)
 * @method GestionCours|null findOneBy(array $criteria, array $orderBy = null)
 * @method GestionCours[]    findAll()
 * @method GestionCours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GestionCoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GestionCours::class);
    }

//    /**
//     * @return GestionCours[] Returns an array of GestionCours objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GestionCours
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
