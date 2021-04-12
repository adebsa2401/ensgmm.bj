<?php

namespace App\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private $createdAt;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private $updatedAt;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist()]
    #[ORM\PreUpdate()]
    public function setTimestamps(): self
    {
        $currentTime = new DateTimeImmutable;
        $this->createdAt ??= $currentTime;
        $this->updatedAt = $currentTime;

        return $this;
    }
}
