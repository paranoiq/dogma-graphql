<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Http;

use Dogma\Http\HttpHeader;
use Dogma\InvalidValueException;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\StringType;
use GraphQL\Utils\Utils;

class HttpHeaderType extends StringType
{

    public const NAME = 'HttpHeader';

    /** @var string */
    public $name = self::NAME;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Http\HttpHeader $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Http\HttpHeader
     */
    public function parseValue($value): HttpHeader
    {
        try {
            return HttpHeader::get($value);
        } catch (InvalidValueException $e) {
            throw new Error('Cannot represent following value as HttpHeader: ' . Utils::printSafeJson($value));
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param mixed[]|null $variables
     * @return \Dogma\Http\HttpHeader
     */
    public function parseLiteral($valueNode, ?array $variables = null): HttpHeader
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, $valueNode);
        }

        return $this->parseValue($valueNode->value);
    }

}
