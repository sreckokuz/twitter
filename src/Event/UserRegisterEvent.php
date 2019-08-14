<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 13/08/2019
 * Time: 20:55
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event
{
    public const NAME = 'user.register';
    /**
     * @var User
     */
    private $registerUser;

    public function __construct(User $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    /**
     * @return User
     */
    public function getRegisterUser(): User
    {
        return $this->registerUser;
    }


}