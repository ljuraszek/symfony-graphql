<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Tag;
use App\Repository\Query\Tag\Model\TagModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class TagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tag::class);
    }
    
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
            TagModel::class,
            $alias
        );
        
        return $this->createQueryBuilder($alias)->select($model);
    }
    
    public function entityManager(): EntityManagerInterface
    {
        return $this->getEntityManager();
    }
}
