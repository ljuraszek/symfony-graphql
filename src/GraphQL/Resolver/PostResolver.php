<?php declare(strict_types = 1);

namespace App\GraphQL\Resolver;

use App\Entity\Post;
use App\Repository\PostRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class PostResolver implements ResolverInterface
{
    /** @var PostRepository */
    private $postRepository;
    
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    
    public function __invoke(ResolveInfo $info, $value, Argument $args)
    {
        $method = $info->fieldName;
        return $this->$method($value, $args);
    }
    
    public function find(int $id) :Post
    {
        return $this->postRepository->find($id);
    }
    
    public function topic(Post $post) :string
    {
        return $post->getTopic();
    }
    
    public function content(Post $post): string
    {
        return $post->getContent();
    }
}
