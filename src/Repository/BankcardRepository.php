<?php

namespace App\Repository;

use App\Entity\Bankcard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bankcard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bankcard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bankcard[]    findAll()
 * @method Bankcard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankcardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bankcard::class);
    }

//    /**
//     * @return Bankcard[] Returns an array of Bankcard objects
//     */
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
    public function findOneBySomeField($value): ?Bankcard
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
