<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use App\Traits\HasUuid;
use App\Traits\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\Table(name="comments")
 */
class Comment
{
    use HasUuid, Timestampable;
    
    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Comment::class, inversedBy="childComments")
     */
    private $parentComment;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="parentComment")
     */
    private $childComments;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Admin::class, inversedBy="comments")
     */
    private $createdByAdmin;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="comments")
     */
    private $createdByStudent;

    public function __construct()
    {
        $this->childComments = new ArrayCollection();
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getParentComment(): ?self
    {
        return $this->parentComment;
    }

    public function setParentComment(?self $parentComment): self
    {
        $this->parentComment = $parentComment;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildComments(): Collection
    {
        return $this->childComments;
    }

    public function addChildComment(self $childComment): self
    {
        if (!$this->childComments->contains($childComment)) {
            $this->childComments[] = $childComment;
            $childComment->setParentComment($this);
        }

        return $this;
    }

    public function removeChildComment(self $childComment): self
    {
        if ($this->childComments->removeElement($childComment)) {
            // set the owning side to null (unless already changed)
            if ($childComment->getParentComment() === $this) {
                $childComment->setParentComment(null);
            }
        }

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedByAdmin(): ?Admin
    {
        return $this->createdByAdmin;
    }

    public function setCreatedByAdmin(?Admin $createdByAdmin): self
    {
        $this->createdByAdmin = $createdByAdmin;

        return $this;
    }

    public function getCreatedByStudent(): ?Student
    {
        return $this->createdByStudent;
    }

    public function setCreatedByStudent(?Student $createdByStudent): self
    {
        $this->createdByStudent = $createdByStudent;

        return $this;
    }
}
