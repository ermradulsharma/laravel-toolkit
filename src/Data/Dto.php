<?php

namespace Skywalker\Support\Data;

use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use ReflectionProperty;

/**
 * @phpstan-consistent-constructor
 */
abstract class Dto implements Arrayable
{
    /**
     * Create a new DTO instance.
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Create a new DTO instance from array.
     */
    public static function fromArray(array $data)
    {
        return new static($data);
    }

    /**
     * Get the instance as an array.
     */
    public function toArray()
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        $result = [];

        foreach ($properties as $property) {
            $result[$property->getName()] = $property->getValue($this);
        }

        return $result;
    }

    /**
     * Generate JSON Schema for the DTO.
     */
    public static function toJsonSchema()
    {
        $reflection = new ReflectionClass(static::class);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        $schema = [
            '$schema' => 'http://json-schema.org/draft-07/schema#',
            'type' => 'object',
            'properties' => [],
            'required' => [],
        ];

        foreach ($properties as $property) {
            $type = $property->getType();
            $typeName = $type ? $type->getName() : 'string';

            // Basic mapping of PHP types to JSON schema types
            $jsonType = match ($typeName) {
                'int' => 'integer',
                'bool' => 'boolean',
                'array' => 'array',
                'float' => 'number',
                default => 'string',
            };

            $schema['properties'][$property->getName()] = [
                'type' => $jsonType,
            ];

            if ($type && ! $type->allowsNull()) {
                $schema['required'][] = $property->getName();
            }
        }

        return $schema;
    }
}
