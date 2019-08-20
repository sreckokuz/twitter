<?php

namespace App\Repository;

use App\Entity\ConfirmationToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConfirmationToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfirmationToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfirmationToken[]    findAll()
 * @method ConfirmationToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfirmationTokenRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConfirmationToken::class);
    }

    // /**
    //  * @return ConfirmationToken[] Returns an array of ConfirmationToken objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConfirmationToken
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
