<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Post;
use App\Repository\Query\Post\Model\PostModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }
    
    public function find($id, $lockMode = null, $lockVersion = null): ?PostModel
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
            PostModel::class,
            $alias
        );
        
        return $this->createQueryBuilder($alias)->select($model);
    }
}
