<?php

namespace Skywalker\Support\Database\Repository;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;
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
     * @throws \Skywalker\Support\Exceptions\PackageException
     */
    protected function resolveModel()
    {
        $modelClass = $this->model();

        if (! class_exists($modelClass)) {
            throw new PackageException("Class {$modelClass} does not exist.");
        }

        return Container::getInstance()->make($modelClass);
    }

    /**
     * Specify the model class name.
     */
    abstract public function model();

    /**
     * {@inheritDoc}
     */
    public function all(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * {@inheritDoc}
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, array $data)
    {
        $item = $this->find($id);

        if ($item) {
            return $item->update($data);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        $item = $this->find($id);

        if ($item) {
            return $item->delete();
        }

        return false;
    }
}
