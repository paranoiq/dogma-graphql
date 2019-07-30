<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Time;

use Dogma\Time\Date;
use Dogma\Time\InvalidDateTimeException;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

class DateType extends ScalarType
{

    public const NAME = 'Date';

    /** @var string */
    public $name = self::NAME;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Time\Date $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->format('Y-m-d');
    }

    /**
     * @param mixed $value
     * @return \Dogma\Time\Date
     */
    public function parseValue($value): Date
    {
        try {
            return new Date($value);
        } catch (InvalidDateTimeException $e) {
            throw new Error('Cannot represent following value as Date: ' . Utils::printSafeJson($value));
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param mixed[]|null $variables
     * @return \Dogma\Time\Date
     */
    public function parseLiteral($valueNode, ?array $variables = null): Date
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, $valueNode);
        }

        return $this->parseValue($valueNode->value);
    }

}
