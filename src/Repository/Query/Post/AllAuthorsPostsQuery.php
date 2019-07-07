<?php declare(strict_types = 1);

namespace App\Repository\Query\Post;

use App\Entity\Author;

final class AllAuthorsPostsQuery extends PostQuery
{
    public function execute(Author $author, ?int $limit, ?int $offset)
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
