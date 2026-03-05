<?php

namespace Skywalker\Support\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HexColor implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  mixed  $value
     * @param  \Closure(string)  $fail
     */
    public function validate(string $attribute, $value, Closure $fail)
    {
        if (! is_string($value) || ! preg_match('/^#?([a-fA-F0-9]{3}){1,2}$/', $value)) {
            $fail('The  must be a valid hex color.');
        }
    }
}
