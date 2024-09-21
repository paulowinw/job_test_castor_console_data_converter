<?php

namespace ConversionValueObjects;

use Castor\ConversionValueObjects\ConvertMonthsToWeeks;
use PHPUnit\Framework\TestCase;

class ConvertMonthsToWeeksTest extends TestCase
{
    public function testGetMonths()
    {
        $converter = new ConvertMonthsToWeeks(3);
        $this->assertEquals(3, $converter->getMonths());
    }

    public function testGetWeeks()
    {
        $cases = [
            [1, 4],
            [3, 12],
            [0, 0],
        ];

        foreach ($cases as [$months, $expectedWeeks]) {
            $converter = new ConvertMonthsToWeeks($months);
            $this->assertEquals($expectedWeeks, $converter->getWeeks());
        }
    }

    public function testTransform()
    {
        $cases = [
            [1, 4],
            [3, 12],
            [0, 0],
        ];

        foreach ($cases as [$months, $expectedWeeks]) {
            $converter = new ConvertMonthsToWeeks($months);
            $this->assertEquals($expectedWeeks, $converter->transform());
        }
    }

    public function testConstructorValidation()
    {
        $this->expectException(\TypeError::class);
        $converter = new ConvertMonthsToWeeks('invalid');
    }


    public function testGetWeeksNegativeMonths()
    {
        $converter = new ConvertMonthsToWeeks(-3);
        $this->assertEquals(-12, $converter->getWeeks());
    }

    public function testGetWeeksZeroMonths()
    {
        $converter = new ConvertMonthsToWeeks(0);
        $this->assertEquals(0, $converter->getWeeks());
    }

    public function testTransformNegativeMonths()
    {
        $converter = new ConvertMonthsToWeeks(-3);
        $this->assertEquals(-12, $converter->transform());
    }

    public function testTransformZeroMonths()
    {
        $converter = new ConvertMonthsToWeeks(0);
        $this->assertEquals(0, $converter->transform());
    }

    public function testStringToIntegerConversion()
    {
        $converter = new ConvertMonthsToWeeks('2');

        $this->assertEquals(8, $converter->transform());
    }
}