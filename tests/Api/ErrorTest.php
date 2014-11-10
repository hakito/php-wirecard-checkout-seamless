<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class ErrorTest extends \PHPUnit_Framework_TestCase
{

    /** @var Error */
    public $t;

    public function setUp()
    {
        $this->t = new Error();
    }

    public function testGetters()
    {
        $container = &$this->t->GetContainerData();
        $container['errorCode'] = 'a';
        $container['message'] = 'b';
        $container['consumerMessage'] = 'c';
        $container['paySysMessage'] = 'd';

        $this->AssertEquals('a', $this->t->GetCode());
        $this->AssertEquals('b', $this->t->GetMessage());
        $this->AssertEquals('c', $this->t->GetConsumerMessage());
        $this->AssertEquals('d', $this->t->GetPaySysMessage());
    }

}
