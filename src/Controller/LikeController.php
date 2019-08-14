<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Event\LikeNotificationEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class LikeController extends AbstractController
{
    /**
     * @Route("/like/{id}", name="like_post")
     * @Security("is_granted('ROLE_USER')")
     */

    public function liked(Post $post, Request $request, EventDispatcherInterface $eventDispatcher)
    {
        /** @var User $user */

        $user = $this->getUser();
        $user->addPostsLiked($post);
        $this->getDoctrine()->getManager()->flush();
        $likedPost = new LikeNotificationEvent($post, $user);
        $eventDispatcher->dispatch(LikeNotificationEvent::NAME, $likedPost);
        return new JsonResponse(['count' => $post->getLikedBy()->count()]);
    }

    /**
     * @Route("unlike/{id}", name="unlike_post")
     */
    public function unlike(Post $post, EventDispatcherInterface $eventDispatcher) {
        $user = $this->getUser();
        $post->removeLikedBy($user);
        $this->getDoctrine()->getManager()->flush();
        $unlikedPost = new LikeNotificationEvent($post, $user);
        $eventDispatcher->dispatch('post.unliked', $unlikedPost);
        return new JsonResponse(['count'=>$post->getLikedBy()->count()]);
    }
}
