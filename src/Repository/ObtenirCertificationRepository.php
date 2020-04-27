<?php

namespace App\Repository;

use App\Entity\ObtenirCertification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObtenirCertification|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObtenirCertification|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObtenirCertification[]    findAll()
 * @method ObtenirCertification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObtenirCertificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObtenirCertification::class);
    }

    // /**
    //  * @return ObtenirCertification[] Returns an array of ObtenirCertification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ObtenirCertification
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
