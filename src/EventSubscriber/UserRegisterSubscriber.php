<?php

namespace App\EventSubscriber;

use App\Event\UserRegisterEvent;
use App\Services\MailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegisterSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(MailService $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onUserRegister(UserRegisterEvent $event)
    {
        $this->mailer->sendConfirmationEmail($event->getRegisterUser());
    }

    public static function getSubscribedEvents()
    {
        return [
            'user.register' => 'onUserRegister',
        ];
    }
}
