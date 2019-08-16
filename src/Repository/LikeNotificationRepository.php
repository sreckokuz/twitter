<?php

namespace App\Repository;

use App\Entity\LikeNotification;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LikeNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikeNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikeNotification[]    findAll()
 * @method LikeNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeNotificationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LikeNotification::class);
    }

    public function unlikeNotification(User $user, Post $post) {
        return $this->createQueryBuilder('n')
            ->update('App\Entity\LikeNotification', 'n')
            ->set('n.seen', 'true')
            ->where('n.user = :user')
            ->andWhere('n.post = :post')
            ->setParameter('user', $user)
            ->setParameter('post', $post)
            ->getQuery()
            ->execute();
    }



}
