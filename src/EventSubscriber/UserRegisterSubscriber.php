<?php

namespace App\EventSubscriber;

use App\Event\UserRegisterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegisterSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function onUserRegister(UserRegisterEvent $event)
    {
        $body = $this->twig->render('email/register.html.twig', ['user' => $event->getRegisterUser()]);
        $message = (new \Swift_Message())
            ->setSubject('Welcome to the Fake twett')
            ->setFrom('srk@srk.com')
            ->setTo($event->getRegisterUser()->getEmail())
            ->setBody($body, 'text/html');
        $this->mailer->send($message);

    }

    public static function getSubscribedEvents()
    {
        return [
            'user.register' => 'onUserRegister',
        ];
    }
}
