<?php

class MonthsPregnant implements DataTransformationInterface
{

    private int $months;

    public function __construct(int $months)
    {
        $this->months = $months;
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