<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 14/08/2019
 * Time: 14:26
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class FollowNotificationEvent extends Event
{
    public const NAME = 'follow.user';
    /**
     * @var User
     */
    private $user;
    /**
     * @var User
     */
    private $userToFollow;

    public function __construct(User $user, User $userToFollow)
    {
        $this->user = $user;
        $this->userToFollow = $userToFollow;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return User
     */
    public function getUserToFollow(): User
    {
        return $this->userToFollow;
    }

}