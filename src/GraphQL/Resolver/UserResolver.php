<?php declare(strict_types = 1);

namespace App\GraphQL\Resolver;

use App\Repository\Query\Model\UserModel;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class UserResolver implements ResolverInterface
{
    
    /**
     * @param ResolveInfo $info
     * @param UserModel   $user
     * @param Argument    $args
     *
     * @return int|string|bool
     */
    public function __invoke(ResolveInfo $info, UserModel $user, Argument $args)
    {
        $method = $info->fieldName;
    
        return method_exists($this, $method) ? $this->$method($user, $args) : $user->$method();
    }
}
