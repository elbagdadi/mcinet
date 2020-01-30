<?php

namespace App\Repository;

use App\Entity\DetailsEstimation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DetailsEstimation|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailsEstimation|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailsEstimation[]    findAll()
 * @method DetailsEstimation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailsEstimationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailsEstimation::class);
    }
    public function findByEstimation($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.estimation = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return DetailsEstimation[] Returns an array of DetailsEstimation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailsEstimation
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
