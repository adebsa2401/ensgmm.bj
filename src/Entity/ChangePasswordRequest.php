<?php

namespace App\Entity;

use App\Repository\ChangePasswordRequestRepository;
use App\Traits\HasUuid;
use App\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChangePasswordRequestRepository::class)
 */
class ChangePasswordRequest
{
    use HasUuid, Timestampable;

    /**
     * @ORM\OneToOne(targetEntity=Student::class, cascade={"persist", "remove"})
     */
    private $student;

    /**
     * @ORM\OneToOne(targetEntity=Admin::class, cascade={"persist", "remove"})
     */
    private $admin;

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
