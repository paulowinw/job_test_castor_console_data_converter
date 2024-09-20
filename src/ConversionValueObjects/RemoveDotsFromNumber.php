<?php

namespace Castor\ConversionValueObjects;

class RemoveDotsFromNumber implements DataTransformationInterface
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