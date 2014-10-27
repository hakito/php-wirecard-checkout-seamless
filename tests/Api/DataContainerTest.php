<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class MockDataContainer extends DataContainer
{
    public function Set($name, $value)
    {
        return parent::Set($name, $value);
    }

    public function Get($name)
    {
        return parent::Get($name);
    }

    public function IsEmpty($name)
    {
        return parent::IsEmpty($name);
    }
}

class DataContainerTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockDataContainer */
    public $t;

    public function setUp()
    {
        $this->t = new MockDataContainer();
    }

    public function testSetAndGet()
    {
        $this->t->Set('foo', 'bar');
        $actual = $this->t->Get('foo');
        $this->assertEquals('bar', $actual);
    }

    public function testGetUndefined()
    {
        $this->assertNull($this->t->Get('foo'));
    }

    public function testIsEmptyTrue()
    {
        $this->assertTrue($this->t->IsEmpty('foo'));
    }

    public function testIsEmptyFalse()
    {
        $this->t->Set('foo', 'bar');
        $this->assertFalse($this->t->IsEmpty('foo'));
    }
}