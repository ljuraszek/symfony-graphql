<?php declare(strict_types = 1);

namespace App\Repository\Query;

use App\Entity\Post;
use App\Repository\Query\Model\PostModel;
use App\Repository\Query\Model\TagModel;
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
        return $this->repository->createView('tag')
            ->innerJoin('tag.posts', 'posts')
            ->andWhere('posts = :post')
            ->setMaxResults($limit ?? 10)
            ->setFirstResult($offset ?? 1)
            ->setParameter('post', $this->repository->getReference(Post::class, $post->id()))
            ->getQuery()
            ->getResult()
        ;
    }
}
