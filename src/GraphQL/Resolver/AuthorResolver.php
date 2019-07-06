<?php declare(strict_types = 1);

namespace App\GraphQL\Resolver;

use App\Entity\Author;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\ConnectionInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Paginator;

class AuthorResolver implements ResolverInterface, AliasedInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function __invoke(ResolveInfo $info, $value, Argument $args)
    {
        $method = $info->fieldName;
        return $this->$method($value, $args);
    }
    
    public function find(int $id) :Author
    {
        return $this->entityManager->find(Author::class, $id);
    }
    
    public function all()
    {
        return $this->entityManager->getRepository(Author::class)->findAll();
    }
    
    public function firstName(Author $author) :string
    {
        return $author->getFirstName();
    }
    
    public function lastName(Author $author): string
    {
        return $author->getLastName();
    }
    
    public function posts(Author $author, Argument $args): ConnectionInterface
    {
        $posts = $author->getPosts()->toArray();
    
        $paginator = new Paginator(static function ($offset, $limit) use ($posts) {
            return array_slice($posts, $offset, $limit ?? 10);
        });
        return $paginator->auto($args, count($posts));
    }
    
    public static function getAliases(): array
    {
        return [
            'find' => 'find',
            'all'  => 'all',
        ];
    }
}
