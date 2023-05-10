<?php
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testSum()
    {
        $result = 2 + 2;
        $this->assertEquals(6, $result);
    }

    public function testStringConcatenation()
    {
        $result = "Hello" . " " . "World";
        $this->assertEquals("Hello World", $result);
    }
}