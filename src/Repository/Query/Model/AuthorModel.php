<?php declare(strict_types = 1);

namespace App\Repository\Query\Model;

use DateTime;

final class AuthorModel
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $firstName;
    
    /**
     * @var string
     */
    private $lastName;
    
    /**
     * @var DateTime
     */
    private $registrationDate;
    
    /**
     * @var string
     */
    private $sex;
    
    public function __construct(int $id, string $firstName, string $lastName, DateTime $registrationDate, string $sex)
    {
        $this->id               = $id;
        $this->firstName        = $firstName;
        $this->lastName         = $lastName;
        $this->registrationDate = $registrationDate;
        $this->sex              = $sex;
    }
    
    public function id(): int
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

    public function registrationDate(): DateTime
    {
        return $this->registrationDate;
    }

    public function sex(): string
    {
        return $this->sex;
    }
}
