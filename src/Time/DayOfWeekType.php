<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Time;

use Dogma\InvalidValueException;
use Dogma\Time\DayOfWeek;
use GraphQL\Error\Error;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

class DayOfWeekType extends ScalarType
{

    public const NAME = 'DayOfWeek';

    /** @var string */
    public $name = self::NAME;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Time\DayOfWeek $value
     * @return int
     */
    public function serialize($value): int
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Time\DayOfWeek
     */
    public function parseValue($value): DayOfWeek
    {
        try {
            return DayOfWeek::get((int) $value);
        } catch (InvalidValueException $e) {
            throw new Error('Cannot represent following value as DayOfWeek: ' . Utils::printSafeJson($value));
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param mixed[]|null $variables
     * @return \Dogma\Time\DayOfWeek
     */
    public function parseLiteral($valueNode, ?array $variables = null): DayOfWeek
    {
        if (!$valueNode instanceof IntValueNode) {
            throw new Error('Query error: Can only parse integers got: ' . $valueNode->kind, $valueNode);
        }

        return $this->parseValue($valueNode->value);
    }

}
