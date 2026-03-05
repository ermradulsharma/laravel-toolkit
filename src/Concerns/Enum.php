<?php

namespace Skywalker\Support\Concerns;

trait Enum
{
    /**
     * Get all cases names.
     */
    public static function names()
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Get all cases values.
     */
    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get an associative array of [value => name].
     */
    public static function options()
    {
        return array_combine(self::values(), self::names());
    }

    /**
     * Try to get an Enum instance from a case name (key).
     */
    public static function tryFromKey(string $key)
    {
        foreach (self::cases() as $case) {
            if ($case->name === $key) {
                return $case;
            }
        }

        return null;
    }
}
