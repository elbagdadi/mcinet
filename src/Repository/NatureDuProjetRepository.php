<?php

namespace App\Repository;

use App\Entity\NatureDuProjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NatureDuProjet|null find($id, $lockMode = null, $lockVersion = null)
 * @method NatureDuProjet|null findOneBy(array $criteria, array $orderBy = null)
 * @method NatureDuProjet[]    findAll()
 * @method NatureDuProjet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NatureDuProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NatureDuProjet::class);
    }

    // /**
    //  * @return NatureDuProjet[] Returns an array of NatureDuProjet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NatureDuProjet
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
