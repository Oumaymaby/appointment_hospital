<?php

namespace App\Repository;

use App\Entity\Appointement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Appointement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointement[]    findAll()
 * @method Appointement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointement::class);
    }

    // /**
    //  * @return Appointement[] Returns an array of Appointement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Appointement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
