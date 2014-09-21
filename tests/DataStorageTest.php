<?php

namespace at\externet\WirecardCheckoutSeamless;

class DataStorageTest extends \PHPUnit_Framework_TestCase
{


    public function setup()
    {
        
    }

    public function testFail()
    {
        $ds = new DataStorage();
        $this->assertEmpty($ds);
    }

}
