<?php

namespace Skywalker\Support\Macros;

use Illuminate\Support\Str;

class StringMacros
{
    /**
     * Register the macros.
     */
    public static function register()
    {
        if (Str::hasMacro('isBase64')) {
            return;
        }

        Str::macro('isBase64', function ($value) {
            return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $value);
        });
    }
}
