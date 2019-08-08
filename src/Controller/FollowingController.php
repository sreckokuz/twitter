<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FollowingController extends AbstractController
{
    /**
     * @Route("/following/{id}", name="follow_user")
     */
    public function follow(User $userToFollow)
    {
        /** @var User $user */
        $user = $this->getUser();
        $user->addFollowing($userToFollow);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('main_page');
    }
}
