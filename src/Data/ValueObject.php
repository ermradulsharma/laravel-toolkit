<?php

namespace Skywalker\Support\Data;

use JsonSerializable;

abstract class ValueObject implements JsonSerializable
{
    /**
     * Check equality with another Value Object.
     */
    public function equals(ValueObject $object)
    {
        if (get_class($this) !== get_class($object)) {
            return false;
        }

        return $this->__toString() === $object->__toString();
    }

    /**
     * Return string representation.
     */
    abstract public function __toString();

    /**
     * Serialize to JSON.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->__toString();
    }
}
