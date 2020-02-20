<?php declare(strict_types = 1);

namespace App\GraphQL\Mutator;

use App\Entity\User;
use App\Message\RegisterUserMessage;
use App\Repository\Query\Model\UserModel;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Security;

final class UserMutation implements MutationInterface, AliasedInterface
{
    /** @var MessageBusInterface */
    private $messageBus;
    
    /** @var UserRepository */
    private $userRepository;
    
    /** @var Security */
    private $security;
    
    /** @var JWTTokenManagerInterface */
    private $tokenManager;
    
    public function __construct(MessageBusInterface $messageBus, UserRepository $userRepository, Security $security, JWTTokenManagerInterface $tokenManager)
    {
        $this->messageBus     = $messageBus;
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->tokenManager = $tokenManager;
    }
    
    public function register(string $email, string $password): ?UserModel
    {
        $message = new RegisterUserMessage($email, $password, []);
        
        $this->messageBus->dispatch($message);
        
        return $this->userRepository->findOneByEmail($email);
    }
    
    public function login(): array
    {
        dd($this->security->getUser());
        
        $user = new User('email@email.com', '123');
        
        $token = $this->tokenManager->create($user);
        
//        dd($this->security->getUser());
        
        return [
            'token' => $token
        ];
    }
    
    /**
     * @return array<string>
     */
    public static function getAliases(): array
    {
        return [
            'register' => 'register_user',
            'login' => 'login_user'
        ];
    }
}
