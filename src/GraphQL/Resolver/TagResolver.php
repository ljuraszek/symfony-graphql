<?php declare(strict_types = 1);

namespace App\GraphQL\Resolver;

use App\Repository\Query\Tag\Model\TagModel;
use App\Repository\TagRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class TagResolver implements ResolverInterface
{
    /** @var TagRepository */
    private $tagRepository;
    
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }
    
    /**
     * @param ResolveInfo $info
     * @param TagModel    $value
     * @param Argument    $args
     *
     * @return int|string|bool
     */
    public function __invoke(ResolveInfo $info, TagModel $value, Argument $args)
    {
        $method = $info->fieldName;
        
        return method_exists($this, $method) ? $this->$method($value, $args) : $value->$method();
    }
    
    public function find(int $id): TagModel
    {
        return $this->tagRepository->findOneById($id);
    }
}
