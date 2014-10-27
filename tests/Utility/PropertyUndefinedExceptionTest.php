<?php

namespace at\externet\WirecardCheckoutSeamless\Utility;

class PropertyUndefinedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $t = new PropertyUndefinedException("foo");
        $this->assertEquals("foo", $t->Property);
    }

    public function testMessage()
    {
        $t = new PropertyUndefinedException("foo");
        $this->assertEquals("Property 'foo' is undefined.", $t->getMessage());
    }
}