<?php declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1)
     */
    private $sex;

    /**
     * @var ArrayCollection|array<Post>
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="author", orphanRemoval=true)
     */
    private $posts;

    public function __construct(string $firstName, string $lastName, \DateTime $registrationDate, string $sex)
    {
        $this->posts            = new ArrayCollection();
        $this->firstName        = $firstName;
        $this->lastName         = $lastName;
        $this->registrationDate = $registrationDate;
        $this->sex              = $sex;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function registrationDate(): \DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function sex(): string
    {
        return $this->sex;
    }

    /**
     * @return Collection|array<Post>
     */
    public function posts(): Collection
    {
        return $this->posts;
    }
}
