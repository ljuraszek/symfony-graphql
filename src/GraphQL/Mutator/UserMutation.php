<?php declare(strict_types = 1);

namespace App\GraphQL\Mutator;

use App\Message\RegisterUserMessage;
use App\Repository\Query\Model\UserModel;
use App\Repository\UserRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class UserMutation implements MutationInterface, AliasedInterface
{
    /** @var MessageBusInterface */
    private $messageBus;
    
    /** @var UserRepository */
    private $userRepository;
    
    public function __construct(MessageBusInterface $messageBus, UserRepository $userRepository)
    {
        $this->messageBus     = $messageBus;
        $this->userRepository = $userRepository;
    }
    
    public function register(string $email, string $password): ?UserModel
    {
        $message = new RegisterUserMessage($email, $password, []);
        
        $this->messageBus->dispatch($message);
        
        return $this->userRepository->findOneByEmail($email);
    }
    
    /**
     * @return array<string>
     */
    public static function getAliases(): array
    {
        return [
            'register' => 'register_user',
        ];
    }
}
