<?php declare(strict_types = 1);

namespace App\GraphQL\Mutator;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\Query\Model\PostModel;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class PostMutation implements MutationInterface, AliasedInterface
{
    /** @var PostRepository */
    private $postRepository;
    
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    
    public function updatePost(int $id, string $topic, string $content): PostModel
    {
        /** @var Post $post */
        $post = $this->postRepository->entityManager()->getReference(Post::class, $id);
        
        $post->update($topic, $content);
        
        $this->postRepository->entityManager()->flush();
        
        return $this->postRepository->findOneById($id);
    }
    
    /**
     * @return array<string>
     */
    public static function getAliases(): array
    {
        return [
            'updatePost' => 'update_post',
        ];
    }
}
