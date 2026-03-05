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
     */
    protected function getSchemaBuilder()
    {
        /** @var \Illuminate\Database\DatabaseManager $db */
        $db = app()->make('db');

        return $db->connection($this->hasConnection() ? $this->getConnection() )
            ->getSchemaBuilder();
    }

    /**
     * Set the migration connection name.
     *
     * @param  string  $connection
     * @return $this
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Get the prefixed table name.
     *
     * @return string
     */
    public function getTableName()
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
    public function setTable($table)
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
    public function setPrefix($prefix)
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
    abstract public function up();

    /**
     * Rollback the migration.
     */
    public function down()
    {
        $this->getSchemaBuilder()->dropIfExists($this->getTableName());
    }

    /**
     * Create Table Schema.
     */
    protected function createSchema(Closure $blueprint)
    {
        $this->getSchemaBuilder()->create($this->getTableName(), $blueprint);
    }

    /**
     * Modify a table on the schema.
     */
    protected function table(Closure $callback)
    {
        $this->getSchemaBuilder()->table($this->getTableName(), $callback);
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if connection exists.
     */
    protected function hasConnection()
    {
        return $this->isNotEmpty($this->getConnection());
    }

    /**
     * Check if table has prefix.
     */
    protected function hasPrefix()
    {
        return $this->isNotEmpty($this->prefix);
    }

    /**
     * Check if the value is not empty.
     *
     * @param  string|null  $value
     */
    private function isNotEmpty($value)
    {
        return ! (is_null($value) || empty($value));
    }
}
