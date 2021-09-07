<?php

namespace App\Repository;

use App\Entity\PanierDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PanierDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method PanierDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method PanierDetails[]    findAll()
 * @method PanierDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PanierDetails::class);
    }

    // /**
    //  * @return PanierDetails[] Returns an array of PanierDetails objects
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
    public function findOneBySomeField($value): ?PanierDetails
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
