<?php

namespace Skywalker\Support\Database\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryContract
 */
interface RepositoryContract
{
    /**
     * Get all items.
     */
    public function all(array $columns = ['*']);

    /**
     * Find item by ID.
     *
     * @param  int|string  $id
     */
    public function find($id, array $columns = ['*']);

    /**
     * Create a new item.
     */
    public function create(array $data);

    /**
     * Update an item.
     *
     * @param  int|string  $id
     */
    public function update($id, array $data);

    /**
     * Delete an item.
     *
     * @param  int|string  $id
     */
    public function delete($id);
}
