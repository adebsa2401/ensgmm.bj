<?php

namespace App\Repository;

use App\Entity\AdminRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminRequest[]    findAll()
 * @method AdminRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminRequest::class);
    }

    // /**
    //  * @return AdminRequest[] Returns an array of AdminRequest objects
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
    public function findOneBySomeField($value): ?AdminRequest
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
