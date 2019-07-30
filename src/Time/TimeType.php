<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Doctrine\Time;

use Dogma\Time\InvalidDateTimeException;
use Dogma\Time\Time;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

class TimeType extends ScalarType
{

    public const NAME = 'Time';

    /** @var string */
    public $name = self::NAME;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Time\Time $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->format('H:i:s');
    }

    /**
     * @param mixed $value
     * @return \Dogma\Time\Time
     */
    public function parseValue($value): Time
    {
        try {
            return new Time($value);
        } catch (InvalidDateTimeException $e) {
            throw new Error('Cannot represent following value as Time: ' . Utils::printSafeJson($value));
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param mixed[]|null $variables
     * @return \Dogma\Time\Time
     */
    public function parseLiteral($valueNode, ?array $variables = null): Time
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, $valueNode);
        }

        return $this->parseValue($valueNode->value);
    }

}
