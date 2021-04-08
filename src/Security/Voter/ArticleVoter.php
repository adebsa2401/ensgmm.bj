<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ArticleVoter extends Voter
{
    public const ACTIONS = [
        'ARTICLE_EDIT',
        'ARTICLE_DELETE',
        'ARTICLE_COMMENT'
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
            && $subject instanceof \App\Entity\Article;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if(!$user = $token->getUser()) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'ARTICLE_EDIT':
            case 'ARTICLE_DELETE':
                return $this->security->isGranted('ROLE_ADMIN') ||
                    $user == $subject->getCreatedBy();
            case 'ARTICLE_COMMENT':
                return $subject->isCommentable();
        }

        return false;
    }
}
