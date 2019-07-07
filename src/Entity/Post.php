<?php declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $topic;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $numberOfLikes;

    /**
     * @var Author
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $author;

    /**
     * @var ArrayCollection|array<Tag>
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="posts")
     */
    protected $tags;
    
    /**
     * Post constructor.
     *
     * @param string     $topic
     * @param string     $content
     * @param \DateTime  $createdAt
     * @param int        $numberOfLikes
     * @param Author     $author
     * @param array<Tag> $tags
     */
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
    
    /**
     * @param array<Tag> $tags
     */
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
