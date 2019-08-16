<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findAllUsersFollowingPosts($followingUsers, $id) {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.user in (:following)')
            ->orWhere('p.user = :id')
            ->setParameter('id', $id)
            ->setParameter('following', $followingUsers)
            ->orderBy('p.createdAt', 'desc')
            ->getQuery()
            ->getResult();
    }



}
