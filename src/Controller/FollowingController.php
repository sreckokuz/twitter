<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FollowingController extends AbstractController
{
    /**
     * @Route("/following/{id}", name="follow_user")
     * @Security("is_granted('ROLE_USER')")
     */
    public function follow(User $userToFollow)
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getId()!== $userToFollow->getId()) {
            $user->addFollowing($userToFollow);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'You make follow @' . $userToFollow->getUsername());
        }

        return $this->redirectToRoute('all_user_tweets', ['id'=>$userToFollow->getId()]);
    }

    /**
     * @Route("/unfollow/{id}", name="unfollow_user")
     * @Security("is_granted('ROLE_USER')")
     */
    public function unfollow(User $userToUnfollow) {
        /** @var User $user */
        $user = $this->getUser();
        $user->removeFollowing($userToUnfollow);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('danger', 'You just unfollow @'.$userToUnfollow->getUsername());
        return $this->redirectToRoute('all_user_tweets', ['id'=>$userToUnfollow->getId()]);
    }

}
