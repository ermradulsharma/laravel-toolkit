<?php

namespace Skywalker\Support\Actions;

/**
 * @phpstan-consistent-constructor
 */
abstract class Action
{
    /**
     * Execute the action.
     *
     * @param  mixed  ...$args
     * @return mixed
     */
    abstract public function execute(...$args);

    /**
     * Create a new instance and execute it.
     *
     * @param  mixed  ...$args
     * @return mixed
     */
    public static function run(...$args)
    {
        return (new static)->execute(...$args);
    }
}
