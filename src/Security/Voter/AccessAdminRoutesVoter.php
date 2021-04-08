<?php

namespace App\Security\Voter;

use App\Entity\Admin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AccessAdminRoutesVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Request &&
            strpos($subject->getPathInfo(), '/admin') == 0;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if($subject->getPathInfo() == '/admin/login' ||
            $user instanceof Admin) {
            return true;
        }
        
        return false;
    }
}
