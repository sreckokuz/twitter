<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request)
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("confirm/{token}", name="confirmation_link")
     */
    public function confirm($token) {
        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['confirmationToken' => $token]);
        if ($user !==null) {
            $user->setEnabled(true);
            $user->setConfirmationToken('');
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('security/confirmation.html.twig', ['user'=>$user]);
    }
}