<?php

namespace App\EventSubscriber;

use App\Entity\LikeNotification;
use App\Event\LikeNotificationEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LikeNotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {

        $this->manager = $manager;
    }

    public function onPostLiked(LikeNotificationEvent $event)
    {
        $userLikedPost = $event->getUser();
        $userPost = $event->getPost()->getUser();
        $post = $event->getPost();
        $notification = new LikeNotification();
        $notification->setUser($userPost);
        $notification->setLikedBy($userLikedPost);
        $notification->setPost($post);
        $this->manager->persist($notification);
        $this->manager->flush();
    }

    public function onPostDislike(LikeNotificationEvent $event) {
        
    }

    public static function getSubscribedEvents()
    {
        return [
            'post.liked' => 'onPostLiked',
            'post.unliked' => 'onPostDislike'
        ];
    }
}
