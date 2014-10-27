<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'MockCurlResponse.php';

class DataStorageInitResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var DataStorageInitResponse */
    public $t;

    /** @var MockCurlResponse */
    public $mCurlResponse;

    public function setUp()
    {
        $this->t = new DataStorageInitResponse();
        $this->mCurlResponse = new MockCurlResponse();
    }

    public function testStorageId()
    {
        $expected = '73171af0b8990b9ef2d11b2070f54ad3';
        $this->mCurlResponse->body = 'storageId=' . $expected;
        $this->t->InitFromCurlResponse($this->mCurlResponse);
        $this->assertEquals($expected, $this->t->GetStroageId());
    }

    public function testJavascriptUrl()
    {
        $expected = 'https://checkout.wirecard.com/seamless.js';
        $this->mCurlResponse->body = 'javascriptUrl=' . $expected;
        $this->t->InitFromCurlResponse($this->mCurlResponse);
        $this->assertEquals($expected, $this->t->GetJavascriptUrl());
    }
    
}