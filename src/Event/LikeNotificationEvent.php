<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 13/08/2019
 * Time: 18:23
 */

namespace App\Event;


use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class LikeNotificationEvent extends Event
{
    public const NAME = 'post.liked';
    /**
     * @var Post
     */
    private $post;
    /**
     * @var User
     */
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

}