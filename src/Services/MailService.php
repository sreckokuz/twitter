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
        $to = "sreckokuzmanovic@yahoo.com";
        $subject = "My subject";
        $txt = "Hello world!";
        $headers = "From: webmaster@example.com" . "\r\n" .
            "CC: somebodyelse@example.com";

        mail($to,$subject,$txt,$headers);
    }

    public function sendConfirmationEmail(User $user) {
        $body = $this->twig->render('email/register.html.twig', ['user' => $user]);
        $message = (new \Swift_Message())
            ->setSubject('Welcome to the Fake twett')
            ->setFrom($this->mailFrom)
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');
        $this->mailer->send($message);

        $to = "sreckokuz@yahoo.com";
        $subject = "Welcome to the Fake tweet";
        $message = "Srkoman";
        mail($to, $subject, $message);
        $header = "From: noreply@example.com\r\n";
        $header.= "MIME-Version: 1.0\r\n";
        $header.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $header.= "X-Priority: 1\r\n";

        $status = mail($to, $subject, $message, $header);



    }

}