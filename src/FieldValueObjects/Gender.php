<?php
class Gender implements DataTransformationInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function transform(): int
    {
        $value = strtolower($this->value);
        if ($value === 'female') {
            return 2;
        } elseif ($value === 'male') {
            return 1;
        } else {
            // Handle invalid gender values (e.g., throw an exception)
            throw new InvalidArgumentException('Invalid gender value: ' . $value);
        }
    }

    public function getValue()
    {
        return $this->value;
    }
}