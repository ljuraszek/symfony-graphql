<?php declare(strict_types = 1);

namespace App\Repository\Query\Tag;

use App\Entity\Post;
use App\Repository\Query\Post\Model\PostModel;
use App\Repository\Query\Tag\Model\TagModel;
use Doctrine\ORM\ORMException;

final class AllPostTagsQuery extends TagQuery
{
    /**
     * @param PostModel $post
     * @param int|null  $limit
     * @param int|null  $offset
     *
     * @return array<TagModel>
     *
     * @throws ORMException
     */
    public function execute(PostModel $post, ?int $limit, ?int $offset): array
    {
        $reference = $this->repository->entityManager()->getReference(Post::class, $post->id());
        
        return $this->repository->createView('tag')
            ->innerJoin('tag.posts', 'posts')
            ->andWhere('posts = :post')
            ->setMaxResults($limit ?? 10)
            ->setFirstResult($offset ?? 1)
            ->setParameter('post', $reference)
            ->getQuery()
            ->getResult()
        ;
    }
}
