<?php declare(strict_types = 1);

namespace App\Repository\Query\Post;

use App\Entity\Author;
use App\Repository\Query\Post\Model\PostModel;

final class AllAuthorsPostsQuery extends PostQuery
{
    /**
     * @param Author   $author
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array<PostModel>
     */
    public function execute(Author $author, ?int $limit, ?int $offset): array
    {
        return $this->repository->createView('post')
            ->andWhere('post.author = :author')
            ->setMaxResults($limit ?? 10)
            ->setFirstResult($offset ?? 1)
            ->setParameter('author', $author)
            ->getQuery()
            ->getResult()
        ;
    }
}
