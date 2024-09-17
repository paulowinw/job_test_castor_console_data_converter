<?php

class Length implements DataTransformationInterface
{

    private int $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function transform(): int
    {
        return (int)floor($this->value);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}