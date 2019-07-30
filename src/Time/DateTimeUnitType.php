<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Time;

use Dogma\GraphQL\Enum\StringEnumType;
use Dogma\Time\DateTimeUnit;
use GraphQL\Error\Error;
use GraphQL\Utils\Utils;

class DateTimeUnitType extends StringEnumType
{

    public const NAME = 'DateTimeUnit';

    /** @var string */
    public $name = self::NAME;

    public function __construct()
    {
        $values = [];
        foreach (DateTimeUnit::getAllowedValues() as $value) {
            $values[$value] = ['value' => $value];
        }

        parent::__construct([
            'values' => $values,
        ]);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Time\DateTimeUnit $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Time\DateTimeUnit
     */
    public function parseValue($value): DateTimeUnit
    {
        if (!DateTimeUnit::isValid($value)) {
            throw new Error('Cannot represent following value as DateTimeUnit: ' . Utils::printSafeJson($value));
        }

        return DateTimeUnit::get($value);
    }

}
