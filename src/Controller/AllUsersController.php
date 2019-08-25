<?php

namespace App\Controller;

use App\Entity\FollowNotification;
use App\Entity\LikeNotification;
use App\Entity\Post;
use App\Entity\User;
use App\Services\ChartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AllUsersController extends AbstractController
{
    /**
     * @Route("/all/users", name="all_users")
     */
    public function index(ChartService $chartService)
    {
        return $this->render('all-users/all-users.html.twig',             [
            'user' => $this->getUser(),
            'allUsers' => $this->getDoctrine()->getRepository(User::class)->findAll(),
            'count' => $this->getUser()->getPosts()->count(),
            'usersWith5PostsAndMore' => $this->getDoctrine()->getRepository(User::class)->usersWithMoreThan5Posts(),
            'likeNotifications' => $this->getDoctrine()->getRepository(LikeNotification::class)->findBy(['seen'=>false, 'user'=>$this->getUser()]),
            'followNotifications' => $this->getDoctrine()->getRepository(FollowNotification::class)->findBy(['seen'=>false, 'user'=>$this->getUser()]),
            'mostLikedPostAndUser' => $this->getDoctrine()->getRepository(Post::class)->mostLikedPostAndHisUser(),
            'chartStatistic' => $chartService->getMostLikedUsersStatistic()
        ]);
    }
}
