<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 19/08/2019
 * Time: 20:45
 */

namespace App\Services;


use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostLikesService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function mostLikedPostAndHisUser() {
        $allPosts = $this->entityManager->getRepository(Post::class)->findAll();
        foreach ($allPosts as $post){
            /** @var  Post $post */
            $arrayOfPosts[$post->getId()] = [$post->getLikedBy()->count(), $post->getUser()->getUsername()];
        }
        $p=arsort($arrayOfPosts);
        $idOfMostLikedPost =array_keys($arrayOfPosts)[0];
        $mostLikedPost = $this->entityManager->getRepository(Post::class)->find($idOfMostLikedPost);
        $userWhoHaveMostLikedPost = $mostLikedPost->getUser();
        return [$mostLikedPost, $userWhoHaveMostLikedPost];
    }

}