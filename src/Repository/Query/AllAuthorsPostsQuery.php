<?php declare(strict_types = 1);

namespace App\Repository\Query;

use App\Entity\Author;
use App\Repository\Query\Model\AuthorModel;
use App\Repository\Query\Model\PostModel;
use Doctrine\ORM\ORMException;

final class AllAuthorsPostsQuery extends PostQuery
{
    /**
     * @param AuthorModel $author
     * @param int|null    $limit
     * @param int|null    $offset
     *
     * @return array<PostModel>
     *
     * @throws ORMException
     */
    public function execute(AuthorModel $author, ?int $limit, ?int $offset): array
    {
        $reference = $this->repository->entityManager()->getReference(Author::class, $author->id());
        
        return $this->repository->createView('post')
            ->andWhere('post.author = :author')
            ->setMaxResults($limit ?? 10)
            ->setFirstResult($offset ?? 1)
            ->setParameter('author', $reference)
            ->getQuery()
            ->getResult()
        ;
    }
}
