<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 19/08/2019
 * Time: 21:06
 */

namespace App\Services;


use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ChartService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getMostLikedUsersStatistic() {
        $usersWithMostLikedPosts = $this->entityManager->getRepository(Post::class)->countOfMostLikedUser();
        $countOfAllLikedPosts = $this->entityManager->getRepository(Post::class)->countOfAllLikes();
        if (isset($usersWithMostLikedPosts[0]['count(posts.id)'])) {
            $firsUserLikes = $usersWithMostLikedPosts[0]['count(posts.id)'];
            $firstUserName = $usersWithMostLikedPosts[0]['username'];
        }else {
            $firsUserLikes = 0;
            $firstUserName = '';
        }
        if (isset($usersWithMostLikedPosts[1]['count(posts.id)'])) {
            $secondUserLikes = $usersWithMostLikedPosts[1]['count(posts.id)'];
            $secondUserName = $usersWithMostLikedPosts[1]['username'];
        }
        else {
            $secondUserLikes = 0;
            $secondUserName = '';
        }
        if ($countOfAllLikedPosts[0]['count(post_user.user_id)']>0) {
            $countOfAll = $countOfAllLikedPosts[0]['count(post_user.user_id)'];
            $countInPercent = $countOfAll / 100;
            $firsUserLikesInPercent = number_format($firsUserLikes / $countInPercent, 2);
            $secondUserLikesInPercent = number_format($secondUserLikes / $countInPercent, 2);
        }
        else{
            $firsUserLikesInPercent = 0;
            $secondUserLikesInPercent=0;
        }



        return [$firsUserLikesInPercent, $firstUserName, $secondUserLikesInPercent, $secondUserName];

//        dd($pp[0]['count(post_user.user_id)']);

    }

}