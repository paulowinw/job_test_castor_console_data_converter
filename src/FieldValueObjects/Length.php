<?php

namespace Castor\FieldValueObjects;

class Length implements DataTransformationInterface
{

    private mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    public function transform() : int
    {
        return (int) ($this->value * 100);
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}