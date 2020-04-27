<?php

namespace App\Repository;

use App\Entity\Seminaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Seminaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seminaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seminaire[]    findAll()
 * @method Seminaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeminaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seminaire::class);
    }



    public function getSeminairesCours() {
        $r = $this->getEntityManager()->createQuery('select s,c from App\Entity\Seminaire s join s.cours c');
        return $r->getResult();

    }
    // /**
    //  * @return Seminaire[] Returns an array of Seminaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Seminaire
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
