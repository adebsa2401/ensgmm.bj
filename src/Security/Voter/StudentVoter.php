<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class StudentVoter extends Voter
{
    public const ACTIONS = [
        'STUDENT_EDIT',
        'STUDENT_DELETE'
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
            && $subject instanceof \App\Entity\Student;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if(!$user = $token->getUser()) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'STUDENT_EDIT':
            case 'STUDENT_DELETE':
                return $this->security->isGranted('ROLE_ADMIN') ||
                    $user == $subject;
        }

        return false;
    }
}
