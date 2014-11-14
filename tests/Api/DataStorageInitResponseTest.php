<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'MockRequestsResponse.php';

class DataStorageInitResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var DataStorageInitResponse */
    public $t;

    /** @var MockRequests_Response */
    public $mRequests_Response;

    public function setUp()
    {
        $this->t = new DataStorageInitResponse();
        $this->mRequests_Response = new MockRequests_Response();
    }

    public function testStorageId()
    {
        $expected = '73171af0b8990b9ef2d11b2070f54ad3';
        $this->mRequests_Response->body = 'storageId=' . $expected;
        $this->t->InitFromHttpResponse($this->mRequests_Response);
        $this->assertEquals($expected, $this->t->GetStroageId());
    }

    public function testJavascriptUrl()
    {
        $expected = 'https://checkout.wirecard.com/seamless.js';
        $this->mRequests_Response->body = 'javascriptUrl=' . $expected;
        $this->t->InitFromHttpResponse($this->mRequests_Response);
        $this->assertEquals($expected, $this->t->GetJavascriptUrl());
    }
    
}