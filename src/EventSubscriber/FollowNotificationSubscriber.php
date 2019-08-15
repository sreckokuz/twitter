<?php

namespace App\EventSubscriber;

use App\Entity\FollowNotification;
use App\Event\FollowNotificationEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FollowNotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onFollowUser(FollowNotificationEvent $event)
    {
        $user = $event->getUser();
        $userToFollow = $event->getUserToFollow();
        $followNotification = new FollowNotification();
        $followNotification->setUser($userToFollow);
        $followNotification->setFollowedUser($user);
        $this->entityManager->persist($followNotification);
        $this->entityManager->flush();
    }

    public function onUnfollowUser(FollowNotificationEvent $event) {
        $user = $event->getUser();
        $userToNotify = $event->getUserToFollow();
        $this->entityManager->getRepository(FollowNotification::class)->unfollowNotification($userToNotify, $user);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            'follow.user' => 'onFollowUser',
            'unfollow.user' => 'onUnfollowUser'
        ];
    }
}
