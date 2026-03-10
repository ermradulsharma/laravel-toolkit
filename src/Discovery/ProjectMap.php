<?php

namespace Skywalker\Support\Discovery;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class ProjectMap
{
    /**
     * Generate the project map.
     *
     * @return array{routes: array<int, array<string, mixed>>, models: array<int, array<string, mixed>>, actions: array<int, string|null>, config: array<string, mixed>}
     */
    public function generate(): array
    {
        return [
            'routes' => $this->getRoutes(),
            'models' => $this->getModels(),
            'actions' => $this->getActions(),
            'config' => $this->getImportantConfigs(),
        ];
    }

    /**
     * Get all registered routes.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getRoutes(): array
    {
        $routes = Route::getRoutes();

        // Get the route collection
        $items = $routes->getRoutes();

        /** @var \Illuminate\Support\Collection<int, \Illuminate\Routing\Route> $collection */
        $collection = collect($items);

        /** @var array<int, array<string, mixed>> $result */
        $result = $collection->map(function (\Illuminate\Routing\Route $route) {
            return [
                'uri' => $route->uri(),
                'methods' => $route->methods(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
            ];
        })->values()->toArray();

        return $result;
    }

    /**
     * Discover models and their schemas.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getModels(): array
    {
        $modelPath = app_path('Models');
        if (! File::isDirectory($modelPath)) {
            return [];
        }

        /** @var array<int, array<string, mixed>> $result */
        $result = collect(File::allFiles($modelPath))
            ->map(function ($file) {
                $class = $this->getClassFromFile($file);
                if (! $class || ! is_subclass_of($class, 'Illuminate\Database\Eloquent\Model')) {
                    return null;
                }

                /** @var \Illuminate\Database\Eloquent\Model $instance */
                $instance = new $class;
                $table = $instance->getTable();

                return [
                    'class' => $class,
                    'table' => $table,
                    'columns' => Schema::getColumnListing($table),
                ];
            })
            ->filter()
            ->values()
            ->toArray();

        return $result;
    }

    /**
     * Discover Action classes.
     *
     * @return array<int, string|null>
     */
    protected function getActions(): array
    {
        $actionPath = app_path('Actions');
        if (! File::isDirectory($actionPath)) {
            return [];
        }

        /** @var array<int, string|null> $result */
        $result = collect(File::allFiles($actionPath))
            ->map(function ($file) {
                return $this->getClassFromFile($file);
            })
            ->filter()
            ->values()
            ->toArray();

        return $result;
    }

    /**
     * Get important configuration keys.
     *
     * @return array<string, mixed>
     */
    protected function getImportantConfigs(): array
    {
        return [
            'app_name' => config('app.name'),
            'env' => config('app.env'),
            'debug' => config('app.debug'),
            'timezone' => config('app.timezone'),
        ];
    }

    /**
     * Get class name from file path.
     *
     * @param  \Symfony\Component\Finder\SplFileInfo  $file
     * @return string|null
     */
    protected function getClassFromFile($file): ?string
    {
        $contents = (string) file_get_contents((string) $file->getRealPath());
        if (preg_match('/namespace\s+(.+?);/', $contents, $matches)) {
            $namespace = $matches[1];

            return $namespace.'\\'.str_replace('.php', '', $file->getFilename());
        }

        return null;
    }
}
