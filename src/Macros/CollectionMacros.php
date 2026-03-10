<?php

namespace Skywalker\Support\Macros;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CollectionMacros
{
    /**
     * Register the macros.
     */
    public static function register(): void
    {
        if (Collection::hasMacro('toKebabCase')) {
            return;
        }

        Collection::macro('toKebabCase', function () {
            /** @var Collection<int|string, mixed> $this */
            return $this->mapWithKeys(function ($value, $key) {
                $k = (string) $key;
                /** @phpstan-ignore-next-line */
                return [Str::kebab($k) => is_array($value) || $value instanceof Collection ? collect($value)->toKebabCase()->all() : $value];
            });
        });

        Collection::macro('toCamelCase', function () {
            /** @var Collection<int|string, mixed> $this */
            return $this->mapWithKeys(function ($value, $key) {
                $k = (string) $key;
                /** @phpstan-ignore-next-line */
                return [Str::camel($k) => is_array($value) || $value instanceof Collection ? collect($value)->toCamelCase()->all() : $value];
            });
        });
    }
}
