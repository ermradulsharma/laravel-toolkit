<?php

namespace Skywalker\Support\Support;

use UnitEnum;

class Enums
{
    /**
     * Get enum values as an array.
     *
     * @param  string  $enum
     * @return array
     */
    public static function values(string $enum): array
    {
        return array_column($enum::cases(), 'value');
    }

    /**
     * Get enum names as an array.
     *
     * @param  string  $enum
     * @return array
     */
    public static function names(string $enum): array
    {
        return array_column($enum::cases(), 'name');
    }

    /**
     * Get enum options for dropdowns.
     *
     * @param  string  $enum
     * @return array
     */
    public static function options(string $enum): array
    {
        $options = [];

        foreach ($enum::cases() as $case) {
            $options[$case->value ?? $case->name] = property_exists($case, 'label') ? $case->label : $case->name;
        }

        return $options;
    }
}
