<?php

namespace Skywalker\Support\Concerns;

use Illuminate\Contracts\Validation\Factory;

/**
 * Trait     HasValidator
 *
 * @author   Skywalker <skywalker@example.com>
 */
/**
 * @phpstan-ignore trait.unused
 */
trait HasValidator
{
    /**
     * Get the validator factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    public function validator(): Factory
    {
        return validator();
    }
}
