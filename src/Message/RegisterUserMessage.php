<?php declare(strict_types = 1);

namespace App\Message;

final class RegisterUserMessage
{
    /**
     * @var string
     */
    private $email;
    
    /**
     * @var string
     */
    private $password;
    
    /**
     * @var array<string>
     */
    private $roles;
    
    /**
     * RegisterUserMessage constructor.
     *
     * @param string        $email
     * @param string        $password
     * @param array<string> $roles
     */
    public function __construct(string $email, string $password, array $roles)
    {
        $this->email    = $email;
        $this->password = $password;
        $this->roles    = $roles;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }
    
    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}
