<?php declare(strict_types = 1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class CommonRepository extends ServiceEntityRepository
{
    /** @var string */
    protected $class;
    
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, $this->class);
    }
    
    abstract public function createView(string $alias): QueryBuilder;
    
    public function entityManager(): EntityManagerInterface
    {
        return $this->getEntityManager();
    }
    
    /**
     * @param string $class
     * @param int    $id
     *
     * @return object|null
     * @throws ORMException
     */
    public function getReference(string $class, int $id)
    {
        return $this->entityManager()->getReference($class, $id);
    }
}
