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
use Dogma\Time\DayOfYear;
use GraphQL\Error\Error;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

class DayOfYearType extends ScalarType
{

    public const NAME = 'DayOfYear';

    /** @var string */
    public $name = self::NAME;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Time\DayOfYear $value
     * @return int
     */
    public function serialize($value): int
    {
        return $value->getNumber();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Time\DayOfYear
     */
    public function parseValue($value): DayOfYear
    {
        try {
            return new DayOfYear((int) $value);
        } catch (InvalidValueException $e) {
            throw new Error('Cannot represent following value as DayOfYear: ' . Utils::printSafeJson($value));
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param mixed[]|null $variables
     * @return \Dogma\Time\DayOfYear
     */
    public function parseLiteral($valueNode, ?array $variables = null): DayOfYear
    {
        if (!$valueNode instanceof IntValueNode) {
            throw new Error('Query error: Can only parse integers got: ' . $valueNode->kind, $valueNode);
        }

        return $this->parseValue($valueNode->value);
    }

}
