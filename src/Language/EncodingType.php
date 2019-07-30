<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Language;

use Dogma\GraphQL\Enum\StringEnumType;
use Dogma\Language\Encoding;
use GraphQL\Error\Error;
use GraphQL\Utils\Utils;

class EncodingType extends StringEnumType
{

    public const NAME = 'Encoding';

    /** @var string */
    public $name = self::NAME;

    public function __construct()
    {
        $values = [];
        foreach (Encoding::getAllowedValues() as $value) {
            $values[$value] = ['value' => $value];
        }

        parent::__construct([
            'values' => $values,
        ]);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Language\Encoding $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Language\Encoding
     */
    public function parseValue($value): Encoding
    {
        if (!Encoding::isValid($value)) {
            throw new Error('Cannot represent following value as Encoding: ' . Utils::printSafeJson($value));
        }

        return Encoding::get($value);
    }

}
