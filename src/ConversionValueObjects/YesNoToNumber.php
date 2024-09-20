<?php

namespace Castor\ConversionValueObjects;

class YesNoToNumber implements DataTransformationInterface
{

    private int $months;

    public function __construct(mixed $months)
    {
        $this->months = (int) $months;
    }

    public function getValue(): int
    {
        return $this->months;
    }

    public function getMonths(): int
    {
        return $this->months;
    }

    public function getWeeks(): int
    {
        return $this->months * 4; // Assuming 4 weeks per month
    }

    public function transform() : int
    {
        return $this->getWeeks();
    }
}