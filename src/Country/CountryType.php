<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Country;

use Dogma\Country\Country;
use Dogma\GraphQL\Enum\StringEnumType;
use GraphQL\Error\Error;
use GraphQL\Utils\Utils;

class CountryType extends StringEnumType
{

    public const NAME = 'Country';

    /** @var string */
    public $name = self::NAME;

    public function __construct()
    {
        $values = [];
        foreach (Country::getAllowedValues() as $value) {
            $values[$value] = ['value' => $value];
        }

        parent::__construct([
            'values' => $values,
        ]);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Country\Country $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Country\Country
     */
    public function parseValue($value): Country
    {
        if (!Country::isValid($value)) {
            throw new Error('Cannot represent following value as Country: ' . Utils::printSafeJson($value));
        }

        return Country::get($value);
    }

}
