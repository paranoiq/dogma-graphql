<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Language\Language;

use Dogma\GraphQL\Enum\StringEnumType;
use Dogma\Language\Language;
use GraphQL\Error\Error;
use GraphQL\Utils\Utils;

class LanguageType extends StringEnumType
{

    public const NAME = 'Language';

    /** @var string */
    public $name = self::NAME;

    public function __construct()
    {
        $values = [];
        foreach (Language::getAllowedValues() as $value) {
            $values[$value] = ['value' => $value];
        }

        parent::__construct([
            'values' => $values,
        ]);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Language\Language $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Language\Language
     */
    public function parseValue($value): Language
    {
        if (!Language::isValid($value)) {
            throw new Error('Cannot represent following value as Language: ' . Utils::printSafeJson($value));
        }

        return Language::get($value);
    }

}
