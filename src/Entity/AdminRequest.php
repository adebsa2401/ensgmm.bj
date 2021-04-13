<?php

namespace App\Entity;

use App\Repository\AdminRequestRepository;
use App\Traits\HasUuid;
use App\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AdminRequestRepository::class)
 * @UniqueEntity(fields = {"email"},message ="You have already made a request with this email address")
 * @ORM\Table(name="admin_requests")
 */
class AdminRequest
{
    use HasUuid, Timestampable;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isApproved = false;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isApproved(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsApproved(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
