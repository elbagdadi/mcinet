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

    public function findByUser($user): ?FuturInvestisseur
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.user_id = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
