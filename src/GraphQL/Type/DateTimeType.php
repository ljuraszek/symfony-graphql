<?php declare(strict_types = 1);

namespace App\GraphQL\Type;

use DateTime;
use Exception;
use GraphQL\Language\AST\Node;

class DateTimeType
{
    /**
     * @param DateTime $value
     *
     * @return string
     */
    public static function serialize(DateTime $value): string
    {
        return $value->format('Y-m-d H:i:s');
    }
    
    /**
     * @param string $value
     *
     * @return DateTime
     * @throws Exception
     */
    public static function parseValue($value): DateTime
    {
        return new DateTime($value);
    }
    
    /**
     * @param Node $valueNode
     *
     * @return DateTime
     * @throws Exception
     */
    public static function parseLiteral($valueNode): DateTime
    {
        return new DateTime($valueNode->loc);
    }
}
