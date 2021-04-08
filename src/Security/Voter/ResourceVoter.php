<?php

namespace App\Security\Voter;

use App\Entity\Admin;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ResourceVoter extends Voter
{
    public const ACTIONS = [
        'RESOURCE_DELETE'
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
            && $subject instanceof \App\Entity\Resource;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if(!$user = $token->getUser()) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'RESOURCE_DELETE':
                return $user instanceof Admin &&
                    $this->security->isGranted('ROLE_ADMIN');
        }

        return false;
    }
}
