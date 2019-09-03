<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 20/08/2019
 * Time: 23:46
 */

namespace App\Services;


use App\Entity\User;
class MailService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var string
     */
    private $mailFrom;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig,  $mailFrom)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailFrom = $mailFrom;
    }

    public function sendConfirmationEmail(User $user) {
        $body = $this->twig->render('email/register.html.twig', ['user' => $user]);
        $message = (new \Swift_Message())
            ->setSubject('Welcome to the Fake twett')
            ->setFrom($this->mailFrom)
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }


}