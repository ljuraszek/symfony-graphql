<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Author;
use App\Repository\Query\Author\Model\AuthorModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Author::class);
    }
    
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
            AuthorModel::class,
            $alias
        );
        
        return $this->createQueryBuilder($alias)->select($model);
    }
    
    public function entityManager(): EntityManagerInterface
    {
        return $this->getEntityManager();
    }
}
