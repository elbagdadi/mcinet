<?php

namespace App\Repository;

use App\Entity\Invister;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Invister|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invister|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invister[]    findAll()
 * @method Invister[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvisterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invister::class);
    }

    // /**
    //  * @return Invister[] Returns an array of Invister objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Invister
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
