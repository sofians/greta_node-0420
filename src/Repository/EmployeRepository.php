<?php

namespace App\Repository;

use App\Entity\Employe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employe[]    findAll()
 * @method Employe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employe::class);
    }


    public function getSeminaireInscrits($id) {

        $sql = "Select * from employe inner join inscrit on inscrit.employe_id = employe.id inner join seminaire s on inscrit.seminaire_id = s.id where seminaire_id = :id";
       //dump($sql);
        $query = $this->getEntityManager()->createQuery($sql)->setParameter('id', $id);
        return $query->getResult();
    }

    public function getSalaireSuperieur(float $salaire) : array {
        $dql = $this->getEntityManager()->createQuery("select e from App\Entity\Employe e where e.salaire > :s");
        $dql->setParameter('s', $salaire);
        return $dql->getResult();
    }

    // /**
    //  * @return Employe[] Returns an array of Employe objects
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
    public function findOneBySomeField($value): ?Employe
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
