<?php

namespace Skywalker\Support\Macros;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CollectionMacros
{
    /**
     * Register the macros.
     */
    public static function register()
    {
        if (Collection::hasMacro('toKebabCase')) {
            return;
        }

        Collection::macro('toKebabCase', function () {
            return $this->mapWithKeys(function ($value, $key) {
                return [Str::kebab($key) => is_array($value) || $value instanceof Collection ? collect($value)->toKebabCase()->all() : $value];
            });
        });

        Collection::macro('toCamelCase', function () {
            return $this->mapWithKeys(function ($value, $key) {
                return [Str::camel($key) => is_array($value) || $value instanceof Collection ? collect($value)->toCamelCase()->all() : $value];
            });
        });
    }
}
