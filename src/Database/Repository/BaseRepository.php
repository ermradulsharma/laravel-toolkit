<?php

namespace Skywalker\Support\Database\Repository;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Skywalker\Support\Exceptions\PackageException;

/**
 * Class BaseRepository
 */
abstract class BaseRepository implements RepositoryContract
{
    /**
     * The repository model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    /**
     * Resolve the model from the container.
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Skywalker\Support\Exceptions\PackageException
     */
    protected function resolveModel(): Model
    {
        /** @var class-string<\Illuminate\Database\Eloquent\Model> $modelClass */
        $modelClass = $this->model();

        if (! class_exists($modelClass)) {
            throw new PackageException("Class {$modelClass} does not exist.");
        }

        /** @var \Illuminate\Database\Eloquent\Model $instance */
        $instance = Container::getInstance()->make($modelClass);

        return $instance;
    }

    /**
     * Specify the model class name.
     *
     * @return class-string<\Illuminate\Database\Eloquent\Model>
     */
    abstract public function model(): string;

    /**
     * {@inheritDoc}
     */
    public function all(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->newQuery()->get($columns);
    }

    /**
     * {@inheritDoc}
     */
    public function find($id, array $columns = ['*']): ?Model
    {
        /** @var Model|null $result */
        $result = $this->model->newQuery()->find($id, $columns);

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, array $data): bool
    {
        $item = $this->find($id);

        if ($item instanceof Model) {
            return $item->update($data);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id): ?bool
    {
        $item = $this->find($id);

        if ($item instanceof Model) {
            return $item->delete();
        }

        return false;
    }
}
