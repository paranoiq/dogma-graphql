<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Web;

use Dogma\InvalidValueException;
use Dogma\Web\Url;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\StringType;
use GraphQL\Utils\Utils;

class UrlType extends StringType
{

    public const NAME = 'Url';

    /** @var string */
    public $name = self::NAME;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Web\Url $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Web\Url
     */
    public function parseValue($value): Url
    {
        try {
            return new Url($value);
        } catch (InvalidValueException $e) {
            throw new Error('Cannot represent following value as Url: ' . Utils::printSafeJson($value));
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param mixed[]|null $variables
     * @return \Dogma\Web\Url
     */
    public function parseLiteral($valueNode, ?array $variables = null): Url
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, $valueNode);
        }

        return $this->parseValue($valueNode->value);
    }

}
