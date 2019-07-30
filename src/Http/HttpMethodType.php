<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Http;

use Dogma\GraphQL\Enum\StringEnumType;
use Dogma\Http\HttpMethod;
use GraphQL\Error\Error;
use GraphQL\Utils\Utils;

class HttpMethodType extends StringEnumType
{

    public const NAME = 'HttpMethod';

    /** @var string */
    public $name = self::NAME;

    public function __construct()
    {
        $values = [];
        foreach (HttpMethod::getAllowedValues() as $value) {
            $values[$value] = ['value' => $value];
        }

        parent::__construct([
            'values' => $values,
        ]);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @param \Dogma\Http\HttpMethod $value
     * @return string
     */
    public function serialize($value): string
    {
        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return \Dogma\Http\HttpMethod
     */
    public function parseValue($value): HttpMethod
    {
        if (!HttpMethod::isValid($value)) {
            throw new Error('Cannot represent following value as HttpMethod: ' . Utils::printSafeJson($value));
        }

        return HttpMethod::get($value);
    }

}
