<?php

namespace App\Repository;

use App\Entity\Kamer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Kamer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kamer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kamer[]    findAll()
 * @method Kamer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KamerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Kamer::class);
    }

//    /**
//     * @return Kamer[] Returns an array of Kamer objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kamer
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
