<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Http;

use Dogma\Http\HttpResponseStatus;
use Dogma\InvalidValueException;
use GraphQL\Error\Error;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

class HttpResponseStatusType extends ScalarType
{

    public const NAME = 'HttpResponseStatus';

    /** @var string */
    public $name = self::NAME;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Http\HttpResponseStatus $value
     * @return int
     */
    public function serialize($value): int
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Http\HttpResponseStatus
     */
    public function parseValue($value): HttpResponseStatus
    {
        try {
            return HttpResponseStatus::get((int) $value);
        } catch (InvalidValueException $e) {
            throw new Error('Cannot represent following value as HttpResponseStatus: ' . Utils::printSafeJson($value));
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param mixed[]|null $variables
     * @return \Dogma\Http\HttpResponseStatus
     */
    public function parseLiteral($valueNode, ?array $variables = null): HttpResponseStatus
    {
        if (!$valueNode instanceof IntValueNode) {
            throw new Error('Query error: Can only parse integers got: ' . $valueNode->kind, $valueNode);
        }

        return $this->parseValue($valueNode->value);
    }

}
