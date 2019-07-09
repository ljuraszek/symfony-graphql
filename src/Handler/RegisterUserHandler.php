<?php declare(strict_types = 1);

namespace App\Handler;

use App\Entity\User;
use App\Message\RegisterUserMessage;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class RegisterUserHandler implements MessageHandlerInterface
{
    /** @var UserRepository */
    private $userRepository;
    
    /** @var EncoderFactoryInterface */
    private $encoderFactory;
    
    public function __construct(UserRepository $userRepository, EncoderFactoryInterface $encoderFactory)
    {
        $this->userRepository = $userRepository;
        $this->encoderFactory = $encoderFactory;
    }
    
    public function __invoke(RegisterUserMessage $message): void
    {
        $encoder = $this->encoderFactory->getEncoder(User::class);
        
        $password = $encoder->encodePassword($message->getPassword(), null);
        
        $user = new User($message->getEmail(), $password);
        
        $this->userRepository->add($user);
    }
}
