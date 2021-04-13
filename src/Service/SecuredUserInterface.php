<?php

namespace App\Service;

use Symfony\Component\Security\Core\User\UserInterface;

interface SecuredUserInterface extends UserInterface {
    public function getEmail();

    public function setEmail(string $email): self;

    public function setPassword(string $password): self;

    public function setRoles(array $roles): self;
}
