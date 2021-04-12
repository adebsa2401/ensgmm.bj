<?php

namespace App\Security\Voter;

use App\Repository\AdminRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class AdminVoter extends Voter
{
    public const ACTIONS = [
        'EDIT_ADMIN',
        'DELETE_ADMIN',
        'IS_FIRST_ADMIN'
    ];

    private $security;
    private $adminRepo;

    public function __construct(Security $security, AdminRepository $adminRepo) {
        $this->security = $security;
        $this->adminRepo = $adminRepo;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, self::ACTIONS)
            && ($subject instanceof \App\Entity\Admin ||
                $subject == null);
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
            case 'IS_FIRST_ADMIN':
                return empty($this->adminRepo->findAll());
        }

        return false;
    }
}
