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
        $output = Num::isInt(5);
        $message = "Testing 5 as int type";
        $this->assertTrue($output, $message);

        $output = Num::isInt("9");
        $message = "Testing 9 as string type";
        $this->assertTrue($output, $message);

        $output = Num::isInt(3.28);
        $message = "Testing 3.28 as float type";
        $this->assertFalse($output, $message);

        $output = Num::isInt("this is a string");
        $message = "Testing a string without numbers";
        $this->assertFalse($output, $message);

        $output = Num::isInt("1. Although this contains a number is not an int");
        $message = "Testing a string with a number";
        $this->assertFalse($output, $message);
    }

    /**
     * Tests the Num::between function
     */
    public function testBetween()
    {
        /**
         * Tests for value = 5
         */
        $num_low = 3;
        $num_high = 12;
        $value = 5;
        
        $output = Num::between($value, $num_low, $num_high, false, false);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, false, true);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, false);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, true);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);

        /**
         * Tests for value = 7
         */
        $num_low = "7";
        $num_high = 12;
        $value = 7;

        $output = Num::between($value, $num_low, $num_high, false, false);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, false, true);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertFalse($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, false);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, true);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);

        /**
         * Tests for value = 12
         */
        $num_low = "7";
        $num_high = 12;
        $value = 12;
        
        $output = Num::between($value, $num_low, $num_high, false, false);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, false, true);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, false);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, true);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);

        /**
         * Tests for value = 2
         */
        $num_low = 12;
        $num_high = 3;
        $value = 2;

        $output = Num::between($value, $num_low, $num_high, false, false);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, false, true);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertFalse($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, false);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, true);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertFalse($output, $message);

        /**
         * Tests for value = "5"
         */
        $num_low = 12;
        $num_high = 3;
        $value = "5";

        $output = Num::between($value, $num_low, $num_high, false, false);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, false, true);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, false);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);
        
        $output = Num::between($value, $num_low, $num_high, true, true);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);
    }
}
