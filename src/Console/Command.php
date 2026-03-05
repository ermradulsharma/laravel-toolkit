<?php

namespace Skywalker\Support\Console;

use Symfony\Component\Console\Helper\TableSeparator;

/**
 * Class     Command
 *
 * @author   Skywalker <skywalker@example.com>
 */
abstract class Command extends \Illuminate\Console\Command
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    abstract public function handle();

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Create a new table separator instance.
     */
    protected function tableSeparator()
    {
        return new TableSeparator;
    }

    /**
     * Display a framed information box.
     */
    protected function frame(string $text)
    {
        $line = '+'.str_repeat('-', strlen($text) + 4).'+';

        $this->info($line);
        $this->info("|  $text  |");
        $this->info($line);
    }
}
