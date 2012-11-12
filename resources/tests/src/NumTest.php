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
     *
     * @test
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
     *
     * @test
     */
    public function testBetween()
    {
        /**
         * Tests for value = 5
         */
        $num_low = 3;
        $num_high = 12;
        $value = 5;

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_NON_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_HIGH_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_LOW_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_BOTH_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);

        /**
         * Tests for value = 7
         */
        $num_low = "7";
        $num_high = 12;
        $value = 7;

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_NON_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_HIGH_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_LOW_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_BOTH_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);

        /**
         * Tests for value = 12
         */
        $num_low = "7";
        $num_high = 12;
        $value = 12;

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_NON_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_HIGH_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_LOW_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_BOTH_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);

        /**
         * Tests for value = 2
         */
        $num_low = 12;
        $num_high = 3;
        $value = 2;

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_NON_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_HIGH_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_LOW_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertFalse($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_BOTH_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertFalse($output, $message);

        /**
         * Tests for value = "5"
         */
        $num_low = 12;
        $num_high = 3;
        $value = "5";

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_NON_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_HIGH_INCLUSIVE);
        $message = "Is $value between ]{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_LOW_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}[";
        $this->assertTrue($output, $message);

        $output = Num::between($value, $num_low, $num_high, Num::RANGE_BOTH_INCLUSIVE);
        $message = "Is $value between [{$num_low},{$num_high}]";
        $this->assertTrue($output, $message);
    }

    /**
     * Tests the Num::randomInt function
     *
     * @depends testIsInt
     */
    public function testRandomInt()
    {
        $numTests = 5;

        // Both Inclusive
        for ($i = 0; $i < $numTests; $i++) {
            $rand = Num::randomInt(5);
            $message = "Random number {$rand} in range [0,5]";
            $output = (Num::isInt($rand) and $rand >= 0 and $rand <= 5);
            $this->assertTrue($output, $message);
        }

        // Low Inclusive
        for ($i = 0; $i < $numTests; $i++) {
            $rand = Num::randomInt(5, 2, Num::RANGE_LOW_INCLUSIVE);
            $message = "Random number {$rand} in range [2,5[";
            $output = (Num::isInt($rand) and $rand >= 2 and $rand < 5);
            $this->assertTrue($output, $message);
        }

        // High Inclusive
        for ($i = 0; $i < $numTests; $i++) {
            $rand = Num::randomInt(13, 7, Num::RANGE_HIGH_INCLUSIVE);
            $message = "Random number {$rand} in range ]7,13]";
            $output = (Num::isInt($rand) and $rand > 7 and $rand <= 13);
            $this->assertTrue($output, $message);
        }

        // Non Inclusive
        for ($i = 0; $i < $numTests; $i++) {
            $rand = Num::randomInt(13, 7, Num::RANGE_NON_INCLUSIVE);
            $message = "Random number {$rand} in range ]7,13[";
            $output = (Num::isInt($rand) and $rand > 7 and $rand < 13);
            $this->assertTrue($output, $message);
        }
    }
}
