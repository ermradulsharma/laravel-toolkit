<?php

namespace Skywalker\Support\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeDto extends Command
{
    protected $signature = 'toolkit:dto {name : The name of the DTO class} {--force : Overwrite the DTO if it already exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DTO class';

    public function handle(): int
    {
        /** @phpstan-ignore-next-line */
        $name = (string) $this->argument('name');
        $className = Str::studly(class_basename($name));
        $namespace = (string) (Str::contains($name, '\\')
            ? Str::beforeLast($name, '\\')
            : 'App\\Data\\Dtos');

        $path = $this->getPath($namespace);

        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $filename = $className.'.php';
        $fullPath = $path.DIRECTORY_SEPARATOR.$filename;

        if (file_exists($fullPath) && ! $this->option('force')) {
            $this->error("DTO [{$className}] already exists!");

            return 1;
        }

        $stub = \Skywalker\Support\Filesystem\Stub::create(__DIR__.'/../../../stubs/dto.stub', [
            'NAMESPACE' => $namespace,
            'CLASS' => $className,
        ]);

        if ($stub->saveTo($path, $filename)) {
            $this->info("DTO [{$namespace}\\{$className}] created successfully.");
        } else {
            $this->error('Failed to create DTO.');

            return 1;
        }

        return 0;
    }

    /**
     * Get the destination path.
     *
     * @param  string  $namespace
     * @return string
     */
    protected function getPath($namespace)
    {
        if (Str::startsWith($namespace, 'App\\')) {
            return app_path(str_replace(['App\\', '\\'], ['', DIRECTORY_SEPARATOR], $namespace));
        }

        return base_path(str_replace('\\', DIRECTORY_SEPARATOR, $namespace));
    }
}
