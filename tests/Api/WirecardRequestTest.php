<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class WirecardRequestTestMock extends WirecardRequest {}

class WirecardRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var WirecardRequestTestMock */
    public $t;

    public function setUp()
    {
        parent::setUp();
        $this->t = new WirecardRequestTestMock(null, null);
    }

    public function testCustomerId()
    {
        $this->t->SetCustomerId('foo');
        $this->assertEquals('foo', $this->t->GetCustomerId());
    }

    public function testLanguage()
    {
        $this->t->SetLanguage('foo');
        $this->assertEquals('foo', $this->t->GetLanguage());
    }
}