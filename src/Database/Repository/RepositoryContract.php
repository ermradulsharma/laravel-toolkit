<?php

namespace Skywalker\Support\Database\Repository;

/**
 * Interface RepositoryContract
 */
interface RepositoryContract
{
    /**
     * Get all items.
     *
     * @param  array<int, string>  $columns
     * @return \Illuminate\Database\Eloquent\Collection<int, \Illuminate\Database\Eloquent\Model>
     */
    public function all(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    /**
     * Find item by ID.
     *
     * @param  int|string  $id
     * @param  array<int, string>  $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id, array $columns = ['*']): ?\Illuminate\Database\Eloquent\Model;

    /**
     * Create a new item.
     *
     * @param  array<string, mixed>  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data): \Illuminate\Database\Eloquent\Model;

    /**
     * Update an item.
     *
     * @param  int|string  $id
     * @param  array<string, mixed>  $data
     * @return bool
     */
    public function update($id, array $data): bool;

    /**
     * Delete an item.
     *
     * @param  int|string  $id
     * @return bool|null
     */
    public function delete($id): ?bool;
}
