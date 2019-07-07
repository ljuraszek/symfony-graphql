<?php declare(strict_types = 1);

namespace App\GraphQL\Resolver;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\Query\Author\Model\AuthorModel;
use App\Repository\Query\Post\AllAuthorsPostsQuery;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Error\UserError;
use Overblog\GraphQLBundle\Relay\Connection\ConnectionInterface;
use Overblog\GraphQLBundle\Relay\Connection\Paginator;

final class AuthorResolver implements ResolverInterface, AliasedInterface
{
    /** @var AllAuthorsPostsQuery */
    private $allAuthorsPostsQuery;
    
    /** @var AuthorRepository */
    private $authorRepository;
    
    public function __construct(AuthorRepository $authorRepository, AllAuthorsPostsQuery $allAuthorsPostsQuery)
    {
        $this->allAuthorsPostsQuery = $allAuthorsPostsQuery;
        $this->authorRepository     = $authorRepository;
    }
    
    /**
     * @param ResolveInfo $info
     * @param AuthorModel      $author
     * @param Argument    $args
     *
     * @return int|string|bool
     */
    public function __invoke(ResolveInfo $info, AuthorModel $author, Argument $args)
    {
        $method = $info->fieldName;
    
        return method_exists($this, $method) ? $this->$method($author, $args) : $author->$method();
    }
    
    public function find(int $id): AuthorModel
    {
        $author = $this->authorRepository->findOneById($id);
        if ($author === null) {
            throw new UserError('Author not found');
        }
        
        return $author;
    }
    
    /**
     * @return array<Author>
     */
    public function all(): array
    {
        return $this->authorRepository->all();
    }
    
    public function posts(AuthorModel $author, Argument $args): ConnectionInterface
    {
        $query     = $this->allAuthorsPostsQuery;
        $paginator = new Paginator(
            static function ($offset, $limit) use ($author, $query) {
                return $query->execute($author, $limit, $offset);
            }
        );
        
        return $paginator->auto($args, count($query->execute($author, null, null)));
    }
    
    /**
     * @return array<string>
     */
    public static function getAliases(): array
    {
        return [
            'find' => 'find',
            'all'  => 'all',
        ];
    }
}
