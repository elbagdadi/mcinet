<?php

namespace App\Repository;

use App\Entity\HasField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method HasField|null find($id, $lockMode = null, $lockVersion = null)
 * @method HasField|null findOneBy(array $criteria, array $orderBy = null)
 * @method HasField[]    findAll()
 * @method HasField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HasFieldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HasField::class);
    }
    public function findBySecteur($secteur)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.secteur = :val')
            ->setParameter('val', $secteur)
            ->orderBy('h.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return HasField[] Returns an array of HasField objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HasField
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
