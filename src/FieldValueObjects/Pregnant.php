<?php

class Pregnant implements DataTransformationInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function transform(): int
    {
        return strtolower($this->value) === 'yes' ? 1 : 0;
    }

    public function getValue()
    {
        return $this->value;
    }
}