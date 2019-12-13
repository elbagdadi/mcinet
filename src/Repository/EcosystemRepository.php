<?php

namespace App\Repository;

use App\Entity\Ecosystem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ecosystem|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ecosystem|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ecosystem[]    findAll()
 * @method Ecosystem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EcosystemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ecosystem::class);
    }

    public function findBySecteur($secteur)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.secteur = :val')
            ->setParameter('val', $secteur)
            ->orderBy('e.sorting', 'ASC')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Ecosystem[] Returns an array of Ecosystem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ecosystem
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
