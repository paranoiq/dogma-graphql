<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\GraphQL\Enum;

use GraphQL\Type\Definition\EnumType as WebonyxEnumType;
use GraphQL\Type\Definition\EnumValueDefinition;

abstract class StringEnumType extends WebonyxEnumType
{

    /**
     * @param string $name
     * @return \GraphQL\Type\Definition\EnumValueDefinition|null
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function getValue($name): ?EnumValueDefinition
    {
        $enumValue = parent::getValue($name);
        if ($enumValue === null) {
            return null;
        }
        return new EnumValueDefinition(['value' => $this->parseValue($enumValue->value)]);
    }

}
