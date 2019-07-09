<?php declare(strict_types = 1);

namespace App\Repository\Query\Model;

use DateTime;

final class UserModel
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $email;
    
    /**
     * @var DateTime
     */
    private $registrationDate;
    
    /**
     * UserModel constructor.
     *
     * @param int      $id
     * @param string   $email
     * @param DateTime $registrationDate
     */
    public function __construct(int $id, string $email, DateTime $registrationDate)
    {
        $this->id               = $id;
        $this->email            = $email;
        $this->registrationDate = $registrationDate;
    }
    
    public function id(): int
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }
    
    public function registrationDate(): DateTime
    {
        return $this->registrationDate;
    }
}
