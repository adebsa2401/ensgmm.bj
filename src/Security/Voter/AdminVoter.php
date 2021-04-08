<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class AdminVoter extends Voter
{
    public const ACTIONS = [
        'EDIT_ADMIN',
        'DELETE_ADMIN'
    ];

    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, self::ACTIONS)
            && $subject instanceof \App\Entity\Admin;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if(!$user = $token->getUser()) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'EDIT_ADMIN':
            case 'DELETE_ADMIN':
                return $this->security->isGranted('ROLE_SUPER_ADMIN') ||
                    $user == $subject;
        }

        return false;
    }
}
