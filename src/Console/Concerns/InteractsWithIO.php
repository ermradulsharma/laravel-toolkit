<?php

namespace Skywalker\Support\Console\Concerns;

/**
 * @phpstan-ignore trait.unused
 */
trait InteractsWithIO
{
    /**
     * Display a success message in a box.
     */
    protected function successBox(string $message)
    {
        $this->output->block($message, 'SUCCESS', 'fg=black;bg=green', ' ', true);
    }

    /**
     * Display an error message in a box.
     */
    protected function errorBox(string $message)
    {
        $this->output->block($message, 'ERROR', 'fg=white;bg=red', ' ', true);
    }

    /**
     * Display an info message in a box.
     */
    protected function infoBox(string $message)
    {
        $this->output->block($message, 'INFO', 'fg=black;bg=cyan', ' ', true);
    }
}
