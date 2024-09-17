<?php

namespace Castor\FieldValueObjects;

class DateDiagnosis implements DataTransformationInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function transform(): string
    {
        // Assuming the input format is DD-MM-YYYY
        $dateParts = explode('-', $this->value);
        return implode('-', array_reverse($dateParts));
    }

    public function getValue()
    {
        return $this->value;
    }
}