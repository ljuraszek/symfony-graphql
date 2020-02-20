<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\User;
use App\Repository\Query\Model\UserModel;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends CommonRepository implements UserLoaderInterface
{
    /** @var string  */
    protected $class = User::class;
    
    /** @var string  */
    protected $modelClass = UserModel::class;
    
    public function add(User $user): void
    {
        $this->entityManager()->persist($user);
        $this->entityManager()->flush();
    }
    
    public function findOneByEmail(string $email): ?UserModel
    {
        return $this->createView('user')
            ->andWhere('user.email = :email')
            ->setMaxResults(1)
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function createView(string $alias): QueryBuilder
    {
        $model = sprintf(
            'NEW %1$s(%2$s.id, %2$s.email, %2$s.registrationDate)',
            $this->modelClass,
            $alias
        );
    
        return $this->createQueryBuilder($alias)->select($model);
    }
    
    public function loadUserByUsername($username)
    {
        return $this->createView('user')
                    ->andWhere('user.email = :email')
                    ->setMaxResults(1)
                    ->setParameter('email', 'test@email.com')
                    ->getQuery()
                    ->getOneOrNullResult()
            ;
    }
}
