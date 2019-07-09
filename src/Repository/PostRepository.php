<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Post;
use App\Repository\Query\Model\PostModel;
use Doctrine\ORM\QueryBuilder;

final class PostRepository extends CommonRepository
{
    /** @var string  */
    protected $class = Post::class;
    
    /** @var string  */
    protected $modelClass = PostModel::class;
    
    public function findOneById(int $id): ?PostModel
    {
        return $this->createView('post')
            ->andWhere('post.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function createView(string $alias): QueryBuilder
    {
        $model = sprintf(
            'NEW %1$s(%2$s.id, %2$s.topic, %2$s.content, %2$s.createdAt, %2$s.numberOfLikes)',
            $this->modelClass,
            $alias
        );
        
        return $this->createQueryBuilder($alias)->select($model);
    }
}
