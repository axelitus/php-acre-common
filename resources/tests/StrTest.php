<?php

namespace axelitus\Acre\Common;

class StrTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // nothing to do here...
    }

    /**
     * Test for Str::lower()
     *
     * @test
     */
    public function test_lower()
    {
        $output = Str::lower('HELLO WORLD');
        $expected = "hello world";

        $this->assertEquals($expected, $output);
    }

    /**
     * Test for Str::upper()
     *
     * @test
     */
    public function test_upper()
    {
        $output = Str::upper('hello world');
        $expected = "HELLO WORLD";

        $this->assertEquals($expected, $output);
    }

    /**
     * Test for Str::lcfirst()
     *
     * @test
     */
    public function test_lcfirst()
    {
        $output = Str::lcfirst('Hello World');
        $expected = "hello World";

        $this->assertEquals($expected, $output);
    }

    /**
     * Test for Str::ucfirst()
     *
     * @test
     */
    public function test_ucfirst()
    {
        $output = Str::ucfirst('hello world');
        $expected = "Hello world";

        $this->assertEquals($expected, $output);
    }

    /**
     * Test for Str::ucwords()
     *
     * @test
     */
    public function test_ucwords()
    {
        $output = Str::ucwords('hello world');
        $expected = "Hello World";

        $this->assertEquals($expected, $output);
    }
}
