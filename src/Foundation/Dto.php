<?php

namespace Skywalker\Support\Foundation;

use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use ReflectionProperty;

/**
 * @implements Arrayable<string, mixed>
 * @phpstan-consistent-constructor
 */
abstract class Dto implements Arrayable
{
    /**
     * Create a new DTO instance.
     *
     * @param  array<string, mixed>  $data
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
     *
     * @param  array<string, mixed>  $data
     * @return static
     */
    public static function fromArray(array $data): self
    {
        return new static($data);
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
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
     *
     * @return array<string, mixed>
     */
    public static function toJsonSchema(): array
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
            $typeName = ($type instanceof \ReflectionNamedType) ? $type->getName() : 'string';

            // Basic mapping of PHP types to JSON schema types
            switch ($typeName) {
                case 'int':
                    $jsonType = 'integer';
                    break;
                case 'bool':
                    $jsonType = 'boolean';
                    break;
                case 'array':
                    $jsonType = 'array';
                    break;
                case 'float':
                    $jsonType = 'number';
                    break;
                default:
                    $jsonType = 'string';
                    break;
            }

            $schema['properties'][$property->getName()] = [
                'type' => $jsonType,
            ];

            if ($type instanceof \ReflectionNamedType && ! $type->allowsNull()) {
                $schema['required'][] = $property->getName();
            }
        }

        return $schema;
    }
}
