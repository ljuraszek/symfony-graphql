<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $topic;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $numberOfLikes;

    /**
     * @var Author
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var ArrayCollection|Tag[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="posts")
     */
    private $tags;
    
    public function __construct(
        string $topic,
        string $content,
        \DateTime $createdAt,
        int $numberOfLikes,
        Author $author,
        array $tags
    ) {
        $this->tags          = new ArrayCollection();
        $this->topic         = $topic;
        $this->content       = $content;
        $this->createdAt     = $createdAt;
        $this->numberOfLikes = $numberOfLikes;
        $this->author        = $author;
        $this->addTags($tags);
    }

    public function id(): ?int
    {
        return $this->id;
    }
    
    public function addTags(array $tags): void
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }
}
