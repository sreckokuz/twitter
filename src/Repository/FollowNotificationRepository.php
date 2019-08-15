<?php

namespace App\Repository;

use App\Entity\FollowNotification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FollowNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method FollowNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method FollowNotification[]    findAll()
 * @method FollowNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowNotificationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FollowNotification::class);
    }

    // /**
    //  * @return FollowNotification[] Returns an array of FollowNotification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FollowNotification
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function unfollowNotification(User $userWhoFollow,User $notifyUser) {
        return $this->createQueryBuilder('f')
            ->update('App\Entity\FollowNotification', 'f')
            ->set('f.seen', 'true')
            ->where('f.user = :userWhoFollow')
            ->andWhere('f.followedUser = :notifyUser')
            ->setParameter('userWhoFollow', $userWhoFollow)
            ->setParameter('notifyUser', $notifyUser)
            ->getQuery()
            ->getResult();
    }

}
