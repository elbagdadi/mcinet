<?php

namespace App\Repository;

use App\Entity\FuturInvestisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FuturInvestisseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method FuturInvestisseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method FuturInvestisseur[]    findAll()
 * @method FuturInvestisseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuturInvestisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FuturInvestisseur::class);
    }

    // /**
    //  * @return FuturInvestisseur[] Returns an array of FuturInvestisseur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FuturInvestisseur
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
