<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\FollowNotificationEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Annotation\Route;

class FollowingController extends AbstractController
{
    /**
     * @Route("/following/{id}", name="follow_user")
     * @Security("is_granted('ROLE_USER')")
     */
    public function follow(User $userToFollow, EventDispatcherInterface $eventDispatcher)
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getId()!== $userToFollow->getId()) {
            $user->addFollowing($userToFollow);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            //add event to notify user
            $followUser = new FollowNotificationEvent($user, $userToFollow);
            $eventDispatcher->dispatch(FollowNotificationEvent::NAME, $followUser);

            $this->addFlash('success', 'You make follow @' . $userToFollow->getUsername());
        }

        return $this->redirectToRoute('all_user_tweets', ['id'=>$userToFollow->getId()]);
    }

    /**
     * @Route("/unfollow/{id}", name="unfollow_user")
     * @Security("is_granted('ROLE_USER')")
     */
    public function unfollow(User $userToUnfollow, EventDispatcherInterface $eventDispatcher) {
        /** @var User $user */
        $user = $this->getUser();
        $user->removeFollowing($userToUnfollow);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('danger', 'You just unfollow @'.$userToUnfollow->getUsername());
        //add event to remove notification
        $unfollow = new FollowNotificationEvent($user, $userToUnfollow);
        $eventDispatcher->dispatch('unfollow.user', $unfollow);

        return $this->redirectToRoute('all_user_tweets', ['id'=>$userToUnfollow->getId()]);
    }

}
