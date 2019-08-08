<?php

namespace App\Security\Voter;

use App\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PostVoter extends Voter
{
    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    /** $attribute represent action(edit, delete, ...) */
    /** subject is instance of some class on witch we want to implement voter */
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['edit', 'delete'])
            && $subject instanceof Post;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        /** @var  $post Post */
        $post = $subject;
        return $post->getUser()->getId() === $user->getId();

//        // ... (check conditions and return true to grant permission) ...
//        switch ($attribute) {
//            case 'POST_EDIT':
//                // logic to determine if the user can EDIT
//                // return true or false
//                break;
//            case 'POST_DELETE':
//                // logic to determine if the user can VIEW
//                // return true or false
//                break;
//        }

//        return false;
    }
}
