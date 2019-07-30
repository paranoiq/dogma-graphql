<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Doctrine\Money;

use Dogma\GraphQL\Enum\StringEnumType;
use Dogma\Money\Currency;
use GraphQL\Error\Error;
use GraphQL\Utils\Utils;

class CurrencyType extends StringEnumType
{

    public const NAME = 'Currency';

    /** @var string */
    public $name = self::NAME;

    public function __construct()
    {
        $values = [];
        foreach (Currency::getAllowedValues() as $value) {
            $values[$value] = ['value' => $value];
        }

        parent::__construct([
            'values' => $values,
        ]);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Money\Currency $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Money\Currency
     */
    public function parseValue($value): Currency
    {
        if (!Currency::isValid($value)) {
            throw new Error('Cannot represent following value as Currency: ' . Utils::printSafeJson($value));
        }

        return Currency::get($value);
    }

}
