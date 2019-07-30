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
use Dogma\Web\Host;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Utils\Utils;
use PHPStan\Type\StringType;

class HostType extends StringType
{

    public const NAME = 'Host';

    /** @var string */
    public $name = self::NAME;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Web\Host $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->format();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Web\Host
     */
    public function parseValue($value): Host
    {
        try {
            return new Host($value);
        } catch (InvalidValueException $e) {
            throw new Error('Cannot represent following value as Host: ' . Utils::printSafeJson($value));
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param mixed[]|null $variables
     * @return \Dogma\Web\Host
     */
    public function parseLiteral($valueNode, ?array $variables = null): Host
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, $valueNode);
        }

        return $this->parseValue($valueNode->value);
    }

}
