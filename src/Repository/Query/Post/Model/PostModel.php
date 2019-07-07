<?php declare(strict_types = 1);

namespace App\Repository\Query\Post\Model;

use DateTime;

final class PostModel
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $topic;
    
    /**
     * @var string
     */
    private $content;
    
    /**
     * @var DateTime
     */
    private $createdAt;
    
    /**
     * @var string
     */
    private $numberOfLikes;
    
    /**
     * PostModel constructor.
     *
     * @param int      $id
     * @param string   $topic
     * @param string   $content
     * @param DateTime $createdAt
     * @param int      $numberOfLikes
     */
    public function __construct(
        int $id,
        string $topic,
        string $content,
        DateTime $createdAt,
        int $numberOfLikes
    ) {
        $this->id            = $id;
        $this->topic         = $topic;
        $this->content       = $content;
        $this->createdAt     = $createdAt;
        $this->numberOfLikes = $numberOfLikes;
    }
    
    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function topic(): string
    {
        return $this->topic;
    }
    
    /**
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }
    
    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }
    
    public function numberOfLikes(): int
    {
        return $this->numberOfLikes;
    }
}
