<?php

namespace Skywalker\Support\Database;

use Closure;
use Illuminate\Database\Migrations\Migration as IlluminateMigration;
use Illuminate\Database\Schema\Builder;

/**
 * Class     Migration
 *
 * @author   Skywalker <skywalker@example.com>
 */
abstract class Migration extends IlluminateMigration
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The table name.
     *
     * @var string|null
     */
    protected $table;

    /**
     * The table prefix.
     *
     * @var string|null
     */
    protected $prefix;

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    protected function getSchemaBuilder(): Builder
    {
        /** @var \Illuminate\Database\DatabaseManager $db */
        $db = resolve('db');

        return $db->connection($this->hasConnection() ? $this->getConnection() : null)
            ->getSchemaBuilder();
    }

    /**
     * Set the migration connection name.
     *
     * @param  string  $connection
     * @return $this
     */
    public function setConnection($connection): self
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Get the prefixed table name.
     *
     * @return string|null
     */
    public function getTableName(): ?string
    {
        return $this->hasPrefix()
            ? $this->prefix.$this->table
            : $this->table;
    }

    /**
     * Set the table name.
     *
     * @param  string  $table
     * @return $this
     */
    public function setTable($table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Set the prefix name.
     *
     * @param  string  $prefix
     * @return $this
     */
    public function setPrefix($prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Migrate to database.
     */
    abstract public function up(): void;

    /**
     * Rollback the migration.
     */
    public function down(): void
    {
        $this->getSchemaBuilder()->dropIfExists((string) $this->getTableName());
    }

    /**
     * Create Table Schema.
     */
    protected function createSchema(Closure $blueprint): void
    {
        $this->getSchemaBuilder()->create((string) $this->getTableName(), $blueprint);
    }

    /**
     * Modify a table on the schema.
     */
    protected function table(Closure $callback): void
    {
        $this->getSchemaBuilder()->table((string) $this->getTableName(), $callback);
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if connection exists.
     */
    protected function hasConnection(): bool
    {
        return $this->isNotEmpty($this->getConnection());
    }

    /**
     * Get the table prefix.
     *
     * @return string
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * Check if table has prefix.
     */
    protected function hasPrefix(): bool
    {
        return $this->isNotEmpty($this->prefix);
    }

    /**
     * Check if the value is not empty.
     *
     * @param  string|null  $value
     */
    private function isNotEmpty($value): bool
    {
        return ! (is_null($value) || empty($value));
    }
}
