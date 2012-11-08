<?php

namespace axelitus\Acre\Common;

class NumTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // nothing to do here...
    }

    /**
     * Tests the Num::isInt function
     */
    public function testIsInt()
    {
        $this->assertEquals(true, Num::isInt(5), "5 as int type");
        $this->assertEquals(true, Num::isInt("9"), "9 as string type");
        $this->assertEquals(false, Num::isInt(3.28), "3.28 as float type");
        $this->assertEquals(false, Num::isInt("this is a string"), "A string without numbers");
        $this->assertEquals(false, Num::isInt("1. Although this contains a number is not an int"), "A string with a number");
    }

    /**
     * Tests the Num::between function
     */
    public function testBetween()
    {
        $num_low = 3;
        $num_high = 12;
        $str = "7";

        $value = 5;
        $this->assertEquals(true, Num::between($value, $num_low, $num_high, false, false), "Is $value between ]{$num_low},{$num_high}[");
        $this->assertEquals(true, Num::between($value, $num_low, $num_high, false, true), "Is $value between ]{$num_low},{$num_high}]");
        $this->assertEquals(true, Num::between($value, $num_low, $num_high, true, false), "Is $value between [{$num_low},{$num_high}[");
        $this->assertEquals(true, Num::between($value, $num_low, $num_high, true, true), "Is $value between [{$num_low},{$num_high}]");

        $value = 7;
        $this->assertEquals(false, Num::between($value, $str, $num_high, false, false), "Is $value between ]{$str},{$num_high}[");
        $this->assertEquals(false, Num::between($value, $str, $num_high, false, true), "Is $value between ]{$str},{$num_high}]");
        $this->assertEquals(true, Num::between($value, $str, $num_high, true, false), "Is $value between [{$str},{$num_high}[");
        $this->assertEquals(true, Num::between($value, $str, $num_high, true, true), "Is $value between [{$str},{$num_high}]");

        $value = 12;
        $this->assertEquals(false, Num::between($value, $str, $num_high, false, false), "Is $value between ]{$str},{$num_high}[");
        $this->assertEquals(true, Num::between($value, $str, $num_high, false, true), "Is $value between ]{$str},{$num_high}]");
        $this->assertEquals(false, Num::between($value, $str, $num_high, true, false), "Is $value between [{$str},{$num_high}[");
        $this->assertEquals(true, Num::between($value, $str, $num_high, true, true), "Is $value between [{$str},{$num_high}]");

        $value = 2;
        $this->assertEquals(false, Num::between($value, $num_high, $num_low, false, false), "Is $value between ]{$num_low},{$num_high}[");
        $this->assertEquals(false, Num::between($value, $num_high, $num_low, false, true), "Is $value between ]{$num_low},{$num_high}]");
        $this->assertEquals(false, Num::between($value, $num_high, $num_low, true, false), "Is $value between [{$num_low},{$num_high}[");
        $this->assertEquals(false, Num::between($value, $num_high, $num_low, true, true), "Is $value between [{$num_low},{$num_high}]");

        $value = 5;
        $this->assertEquals(true, Num::between($value, $num_high, $num_low, false, false), "Is $value between ]{$num_low},{$num_high}[");
        $this->assertEquals(true, Num::between($value, $num_high, $num_low, false, true), "Is $value between ]{$num_low},{$num_high}]");
        $this->assertEquals(true, Num::between($value, $num_high, $num_low, true, false), "Is $value between [{$num_low},{$num_high}[");
        $this->assertEquals(true, Num::between($value, $num_high, $num_low, true, true), "Is $value between [{$num_low},{$num_high}]");
    }
}
