<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Time;

use Dogma\Time\DateTime;
use Dogma\Time\InvalidDateTimeException;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use const DATE_ATOM;

class DateTimeType extends ScalarType
{

    public const NAME = 'DateTime';

    /** @var string */
    public $name = self::NAME;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Time\DateTime $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->format(DATE_ATOM);
    }

    /**
     * @param mixed $value
     * @return \Dogma\Time\DateTime
     */
    public function parseValue($value): DateTime
    {
        try {
            return DateTime::createFromAnyFormat(DateTime::SAFE_FORMATS, $value);
        } catch (InvalidDateTimeException $e) {
            throw new Error('Cannot represent following value as DateTime: ' . Utils::printSafeJson($value));
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param mixed[]|null $variables
     * @return \Dogma\Time\DateTime
     */
    public function parseLiteral($valueNode, ?array $variables = null): DateTime
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, $valueNode);
        }

        return $this->parseValue($valueNode->value);
    }

}
