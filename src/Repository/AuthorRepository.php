<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Author;
use App\Repository\Query\Model\AuthorModel;
use Doctrine\ORM\QueryBuilder;

final class AuthorRepository extends CommonRepository
{
    /** @var string  */
    protected $class = Author::class;
    
    /** @var string  */
    protected $modelClass = AuthorModel::class;
    
    public function findOneById(int $id): ?AuthorModel
    {
        return $this->createView('author')
            ->andWhere('author.id = :id')
            ->setMaxResults(1)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array<AuthorModel>
     */
    public function all(?int $limit, ?int $offset): array
    {
        return $this->createView('author')
            ->setMaxResults($limit ?? 10)
            ->setFirstResult($offset ?? 1)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function createView(string $alias): QueryBuilder
    {
        $model = sprintf(
            'NEW %1$s(%2$s.id, %2$s.firstName, %2$s.lastName, %2$s.registrationDate, %2$s.sex)',
            $this->modelClass,
            $alias
        );
        
        return $this->createQueryBuilder($alias)->select($model);
    }
}
