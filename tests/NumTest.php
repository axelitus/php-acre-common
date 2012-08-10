<?php

namespace axelitus\Acre\Common;

class NumTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // nothing to do here...
    }

    public function testIsInt()
    {
        $this->assertEquals(true, Num::isInt(5));
        $this->assertEquals(true, Num::isInt("9"));
        $this->assertEquals(false, Num::isInt(3.28));
        $this->assertEquals(false, Num::isInt("this is a string"));
        $this->assertEquals(false, Num::isInt("1. Although this contains a number is not an int"));
    }
}
