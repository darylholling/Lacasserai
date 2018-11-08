<?php

namespace App\Repository;

use App\Entity\Omgeving;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Omgeving|null find($id, $lockMode = null, $lockVersion = null)
 * @method Omgeving|null findOneBy(array $criteria, array $orderBy = null)
 * @method Omgeving[]    findAll()
 * @method Omgeving[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OmgevingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Omgeving::class);
    }

//    /**
//     * @return Omgeving[] Returns an array of Omgeving objects
//     */
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
    public function findOneBySomeField($value): ?Omgeving
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
