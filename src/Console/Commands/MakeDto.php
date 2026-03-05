<?php

namespace Skywalker\Support\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Skywalker\Support\Filesystem\Stub;

class MakeDto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toolkit-dto {name  name of the DTO class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DTO class';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $className = Str::$name);

        // Default to App\Data\Dtos namespace if not specified
        $namespace = 'App\\Data\\Dtos';
        $path = app_path('Data/Dtos');

        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $stub = \Skywalker\Support\Filesystem\Stub::__DIR__.'/../../../stubs/dto.stub', [
            'NAMESPACE' => $namespace,
            'CLASS' => $className,
        ]);

        $filename = $className.'.php';

        if ($stub->saveTo($path, $filename)) {
            $this->info("DTO [{$namespace}\\{$className}] created successfully.");
        } else {
            $this->error('Failed to create DTO.');
        }

        return 0;
    }
}
