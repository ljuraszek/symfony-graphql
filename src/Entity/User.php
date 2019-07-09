<?php declare(strict_types = 1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $email;
    
    /**
     * @var array<string>
     * @ORM\Column(type="json")
     */
    protected $roles = [];
    
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $password;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $token;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $registrationDate;
    
    /**
     * User constructor.
     *
     * @param string        $email
     * @param string        $password
     * @param array<string> $roles
     *
     * @throws \Exception
     */
    public function __construct(string $email, string $password, array $roles = [])
    {
        $this->email            = $email;
        $this->password         = $password;
        $this->roles            = $roles;
        $this->registrationDate = new DateTime();
    }
    
    public function startResetPasswordProcess(): void
    {
        $this->token = 'sdaf';
    }
}
