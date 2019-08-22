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

    public function countOfMostLikedUser()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            select count(posts.id), users.username
            from posts
            INNER JOIN post_user
            on posts.id = post_user.post_id
            INNER join users
            on users.id = posts.user_id
            group by posts.user_id
            order by count(posts.id) DESC 
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countOfAllLikes()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'select count(post_user.user_id) FROM post_user';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function mostLikedPostAndHisUser()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            select count(posts.id), users.username, posts.id
            from posts
            INNER JOIN post_user
            on posts.id = post_user.post_id
            INNER join users
            on users.id = posts.user_id
            group by posts.id
            order by count(posts.id) DESC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }



}
