<?php

namespace ConversionValueObjects;

use Castor\ConversionValueObjects\FemaleMaleToNumber;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FemaleMaleToNumberTest extends TestCase
{
    public function testTransformFemale()
    {
        $converter = new FemaleMaleToNumber('Female');
        $this->assertEquals(2, $converter->transform());
    }

    public function testTransformMale()
    {
        $converter = new FemaleMaleToNumber('Male');
        $this->assertEquals(1, $converter->transform());
    }

    public function testTransformInvalidGender()
    {
        $this->expectException(InvalidArgumentException::class);
        $converter = new FemaleMaleToNumber('InvalidGender');
        $converter->transform();
    }

    public function testTransformCaseInsensitivity()
    {
        $converter1 = new FemaleMaleToNumber('female');
        $converter2 = new FemaleMaleToNumber('Female');
        $converter3 = new FemaleMaleToNumber('MALE');
        $converter4 = new FemaleMaleToNumber('Male');

        $this->assertEquals(2, $converter1->transform());
        $this->assertEquals(2, $converter2->transform());
        $this->assertEquals(1, $converter3->transform());
        $this->assertEquals(1, $converter4->transform());
    }

    public function testGetValue()
    {
        $converter = new FemaleMaleToNumber('Female');
        $this->assertEquals('Female', $converter->getValue());
    }
}