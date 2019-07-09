<?php declare(strict_types = 1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class CommonRepository extends ServiceEntityRepository
{
    protected $class = '';
    
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, $this->class);
    }
    
    abstract protected function createView(string $alias): QueryBuilder;
    
    public function entityManager(): EntityManagerInterface
    {
        return $this->getEntityManager();
    }
}
