<?php

namespace App\Repository;

use App\Entity\Booking1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking1[]    findAll()
 * @method Booking1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Booking1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking1::class);
    }

    // /**
    //  * @return Booking1[] Returns an array of Booking1 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Booking1
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
