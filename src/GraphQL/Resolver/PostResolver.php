<?php declare(strict_types = 1);

namespace App\GraphQL\Resolver;

use App\Repository\PostRepository;
use App\Repository\Query\Model\PostModel;
use App\Repository\Query\AllPostTagsQuery;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\ConnectionInterface;
use Overblog\GraphQLBundle\Relay\Connection\Paginator;

final class PostResolver implements ResolverInterface
{
    /** @var PostRepository */
    private $postRepository;
    
    /** @var AllPostTagsQuery */
    private $allPostTagsQuery;
    
    public function __construct(PostRepository $postRepository, AllPostTagsQuery $allPostTagsQuery)
    {
        $this->postRepository = $postRepository;
        $this->allPostTagsQuery = $allPostTagsQuery;
    }
    
    /**
     * @param ResolveInfo $info
     * @param PostModel   $value
     * @param Argument    $args
     *
     * @return int|string|bool
     */
    public function __invoke(ResolveInfo $info, PostModel $value, Argument $args)
    {
        $method = $info->fieldName;
        
        return method_exists($this, $method) ? $this->$method($value, $args) : $value->$method();
    }
    
    public function find(int $id): PostModel
    {
        return $this->postRepository->findOneById($id);
    }
    
    public function tags(PostModel $post, Argument $args): ConnectionInterface
    {
        $query     = $this->allPostTagsQuery;
        $paginator = new Paginator(
            static function ($offset, $limit) use ($post, $query) {
                return $query->execute($post, $limit, $offset);
            }
        );
    
        return $paginator->auto($args, count($query->execute($post, null, null)));
    }
}
