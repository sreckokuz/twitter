<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FollowNotificationRepository")
 */
class FollowNotification extends Notification
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $followedUser;


    public function getFollowedUser(): ?User
    {
        return $this->followedUser;
    }

    public function setFollowedUser(?User $followedUser): self
    {
        $this->followedUser = $followedUser;

        return $this;
    }
}
