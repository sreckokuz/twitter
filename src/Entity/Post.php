<?php

namespace App\Entity;
use App\Entity\EntityTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="posts")
 * @ORM\HasLifecycleCallbacks()
 */

class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=100, minMessage="Minimum length is 5 characters", maxMessage="Maximum length is 100 characters")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="postsLiked")
     */
    private $likedBy;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LikeNotification", mappedBy="post", cascade={"persist", "remove"})
     */
    private $likeNotifications;

    public function __construct()
    {
        $this->likedBy = new ArrayCollection();
        $this->likeNotifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikedBy(): Collection
    {
        return $this->likedBy;
    }

    public function addLikedBy(User $likedBy): self
    {
        if (!$this->likedBy->contains($likedBy)) {
            $this->likedBy[] = $likedBy;
        }

        return $this;
    }

    public function removeLikedBy(User $likedBy): self
    {
        if ($this->likedBy->contains($likedBy)) {
            $this->likedBy->removeElement($likedBy);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @ORM\PrePersist
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return Collection|LikeNotification[]
     */
    public function getLikeNotifications(): Collection
    {
        return $this->likeNotifications;
    }

    public function addLikeNotification(LikeNotification $likeNotification): self
    {
        if (!$this->likeNotifications->contains($likeNotification)) {
            $this->likeNotifications[] = $likeNotification;
            $likeNotification->setPost($this);
        }

        return $this;
    }

    public function removeLikeNotification(LikeNotification $likeNotification): self
    {
        if ($this->likeNotifications->contains($likeNotification)) {
            $this->likeNotifications->removeElement($likeNotification);
            // set the owning side to null (unless already changed)
            if ($likeNotification->getPost() === $this) {
                $likeNotification->setPost(null);
            }
        }

        return $this;
    }

}
