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
    public function testLower()
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
    public function testUpper()
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
    public function testLcfirst()
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
    public function testUcfirst()
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
    public function testUcwords()
    {
        $output = Str::ucwords('hello world');
        $expected = "Hello World";

        $this->assertEquals($expected, $output);
    }

    /**
     * Test for Str::random()
     *
     * @test
     */
    public function testRandom()
    {
        $output = strlen(Str::random());
        $expected = 1;
        $this->assertEquals($expected, $output);

        $output = strlen(Str::random(16));
        $expected = 16;
        $this->assertEquals($expected, $output);
    }

    /**
     * Test for Str::beginsWith()
     *
     * @test
     */
    public function testBeginsWith()
    {
        $output = Str::beginsWith("Hello World", "Hell");
        $this->assertTrue($output);

        $output = Str::beginsWith("Hello World", "hell");
        $this->assertFalse($output);

        $output = Str::beginsWith("Hello World", "hell", false);
        $this->assertTrue($output);
    }

    /**
     * Test for Str::endsWith()
     *
     * @test
     */
    public function testEndsWith()
    {
        $output = Str::endsWith("Hello World", "orld");
        $this->assertTrue($output);

        $output = Str::endsWith("Hello World", "Orld");
        $this->assertFalse($output);

        $output = Str::endsWith("Hello World", "Orld", false);
        $this->assertTrue($output);
    }

    /**
     * Test for Str::isOneOf()
     *
     * @test
     */
    public function testIsOneOf()
    {
        $animals = array('Monkey', 'Mouse', 'favorite' => 'Dog', 'Cat', 'Penguin');

        $animal = null;
        $output = Str::isOneOf($animal, $animals);
        $this->assertFalse($output);

        $animal = 'Penguin';
        $output = Str::isOneOf($animal, $animals);
        $this->assertTrue($output);

        $animal = 'penguin';
        $output = Str::isOneOf($animal, $animals);
        $this->assertFalse($output);

        $animal = 'penguin';
        $output = Str::isOneOf($animal, $animals, false);
        $this->assertTrue($output);

        $animal = 'Cat';
        $output = Str::isOneOf($animal, $animals, true, true);
        $expected = 2;
        $this->assertEquals($expected, $output);

        $animal = 'Dog';
        $output = Str::isOneOf($animal, $animals, true, true);
        $expected = 'favorite';
        $this->assertEquals($expected, $output);
    }

    /**
     * Test for Str::studly()
     *
     * @test
     */
    public function testStudly()
    {
        $output = Str::studly('This_is_an_underscore Separated_string_With_spaces');
        $expected = 'ThisIsAnUnderscore SeparatedStringWithSpaces';
        $this->assertEquals($expected, $output);

        $output = Str::studly('this_is_an_underscore separated_string_with_spaces');
        $expected = 'ThisIsAnUnderscore SeparatedStringWithSpaces';
        $this->assertEquals($expected, $output);

        $output = Str::studly('This string should be converted to a single word studlyCaps string', array(' '));
        $expected = 'ThisStringShouldBeConvertedToASingleWordStudlyCapsString';
        $this->assertEquals($expected, $output);
    }

    /**
     * Test for Str::camel()
     *
     * @test
     */
    public function testCamel()
    {
        $output = Str::camel('This_is_an_underscore Separated_string_With_spaces');
        $expected = 'thisIsAnUnderscore separatedStringWithSpaces';
        $this->assertEquals($expected, $output);

        $output = Str::camel('this_is_an_underscore separated_string_with_spaces');
        $expected = 'thisIsAnUnderscore separatedStringWithSpaces';
        $this->assertEquals($expected, $output);

        $output = Str::camel('This string should be converted to a single word studlyCaps string', array(' '));
        $expected = 'thisStringShouldBeConvertedToASingleWordStudlyCapsString';
        $this->assertEquals($expected, $output);
    }

    /**
     * Test for Str::separated()
     *
     * @test
     */
    public function testSeparated()
    {
        $output = Str::separated('ThisIsAStudlyCapsString SeparatedWithSpaces');
        $expected = 'This_Is_A_Studly_Caps_String Separated_With_Spaces';
        $this->assertEquals($expected, $output);

        $output = Str::separated('ThisIsAStudlyCapsString SeparatedWithSpaces', 'lower');
        $expected = 'this_is_a_studly_caps_string separated_with_spaces';
        $this->assertEquals($expected, $output);

        $output = Str::separated('ThisIsAStudlyCapsString SeparatedWithSpaces', 'upper');
        $expected = 'THIS_IS_A_STUDLY_CAPS_STRING SEPARATED_WITH_SPACES';
        $this->assertEquals($expected, $output);

        $output = Str::separated('thisIsAStudlyCapsString SeparatedWithSpaces', 'lcfirst');
        $expected = 'this_Is_A_Studly_Caps_String separated_With_Spaces';
        $this->assertEquals($expected, $output);

        $output = Str::separated('thisIsAStudlyCapsString separatedWithSpaces', 'ucfirst');
        $expected = 'This_Is_A_Studly_Caps_String Separated_With_Spaces';
        $this->assertEquals($expected, $output);

        $output = Str::separated('thisIsAStudlyCapsString separatedWithSpaces', 'ucwords');
        $expected = 'This_is_a_studly_caps_string Separated_with_spaces';
        $this->assertEquals($expected, $output);

        $output = Str::separated('single', 'ucfirst');
        $expected = 'Single';
        $this->assertEquals($expected, $output);

        $output = Str::separated('twoWords', 'ucfirst');
        $expected = 'Two_Words';
        $this->assertEquals($expected, $output);
    }
}
