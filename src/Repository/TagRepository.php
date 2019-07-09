<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Tag;
use App\Repository\Query\Model\TagModel;
use Doctrine\ORM\QueryBuilder;

final class TagRepository extends CommonRepository
{
    protected $class = Tag::class;
    protected $modelClass = TagModel::class;
    
    public function findOneById(int $id): ?TagModel
    {
        return $this->createView('tag')
            ->andWhere('post.id = :id')
            ->setMaxResults(1)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function createView(string $alias): QueryBuilder
    {
        $model = sprintf(
            'NEW %1$s(%2$s.id, %2$s.name)',
            $this->modelClass,
            $alias
        );
        
        return $this->createQueryBuilder($alias)->select($model);
    }
}
