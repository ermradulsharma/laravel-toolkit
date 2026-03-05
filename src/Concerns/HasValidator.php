<?php

namespace Skywalker\Support\Concerns;

use Illuminate\Contracts\Validation\Factory;

/**
 * Trait     HasValidator
 *
 * @author   Skywalker <skywalker@example.com>
 */
trait HasValidator
{
    /**
     * Get the validator factory instance.
     */
    public function validator()
    {
        return validator();
    }
}
