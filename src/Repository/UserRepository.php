<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

//   this query is not in use in app
    public function countOfAllUserPosts() {
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->innerJoin('u.posts', 'mp')
            ->andWhere('u.id=1')
            ->getQuery()
            ->getResult();
    }

    public function usersWithMoreThan5Posts() {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.posts', 'p')
            ->groupBy('u')
            ->having('count(p)>5')
            ->getQuery()
            ->getResult();
    }

    public function allUsersExceptCurrentLogInUser(User $user) {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->innerJoin('u.posts', 'p')
            ->groupBy('u')
            ->having('count(p)>5')
            ->andWhere('u != :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function searchUserByTitle($user)
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.fullName LIKE :user')
            ->orWhere('u.username LIKE :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

}


