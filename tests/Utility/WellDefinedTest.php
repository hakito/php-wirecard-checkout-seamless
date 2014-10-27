<?php

namespace at\externet\WirecardCheckoutSeamless\Utility;

class WellDefinedTest extends \PHPUnit_Framework_TestCase
{
    /** @var WellDefined */
    private $t;

    public function setup()
    {
        $this->t = $this->getMockForAbstractClass('at\externet\WirecardCheckoutSeamless\Utility\WellDefined');
    }

    public function testSet()
    {
        $this->setExpectedException('at\externet\WirecardCheckoutSeamless\Utility\PropertyUndefinedException');
        $this->t->Foo = "bar";
    }

    public function testGet()
    {
        $this->setExpectedException('at\externet\WirecardCheckoutSeamless\Utility\PropertyUndefinedException');
        $actual = $this->t->Foo;
    }
}