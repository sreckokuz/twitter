<?php

namespace App\Controller;

use App\Entity\FollowNotification;
use App\Entity\LikeNotification;
use App\Entity\Notification;
use App\Entity\Post;
use App\Entity\User;
use App\Services\ChartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification_count")
     */
    public function notificationCount()
    {
        return new JsonResponse(['notification' => $this->getDoctrine()->getRepository(Notification::class)->
        findCountOfUnseenUserNotifications($this->getUser())]);
    }

    /**
     * @Route("/unseen", name="unseen_notification")
     */
    public function unseenNotification() {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $allLikeNotifications = $this->getDoctrine()->getRepository(LikeNotification::class)->findBy(['seen'=>false,'user' => $currentUser]);
        return new JsonResponse(['likeNotifications' => $allLikeNotifications]);
    }

    /**
     * @Route("notofications/show", name="show_notifications")
     */
    public function showNotifications(ChartService $chartService) {
        return $this->render('notification/show-notifications.html.twig',
            [
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

    /**
     * @Route("notification/{id}", name="single_notification_mark")
     */
    public function singleNotificationMark(Notification $notification) {
        $notification->setSeen('true');
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('show_notifications');
    }

    /**
     * @Route("notifications", name="all_notifications_mark")
     */
    public function allNotificationMark() {
        $this->getDoctrine()->getRepository(Notification::class)->markAllAsRead($this->getUser());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('show_notifications');
    }

}
