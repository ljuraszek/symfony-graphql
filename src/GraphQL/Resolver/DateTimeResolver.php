<?php declare(strict_types = 1);

namespace App\GraphQL\Resolver;

use DateTime;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class DateTimeResolver implements ResolverInterface
{
    public function __invoke(DateTime $dateTime, ?string $format): string
    {
        return $dateTime->format($format ?? 'Y-m-d H:i:s');
    }
}
