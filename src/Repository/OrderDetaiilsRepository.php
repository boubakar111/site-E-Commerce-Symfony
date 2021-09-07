<?php

namespace App\Repository;

use App\Entity\OrderDetaiils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderDetaiils|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetaiils|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetaiils[]    findAll()
 * @method OrderDetaiils[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetaiilsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetaiils::class);
    }

    // /**
    //  * @return OrderDetaiils[] Returns an array of OrderDetaiils objects
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
    public function findOneBySomeField($value): ?OrderDetaiils
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
