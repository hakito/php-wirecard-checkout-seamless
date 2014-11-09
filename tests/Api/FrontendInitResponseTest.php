<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'MockCurlResponse.php';

class FrontendInitResponseTest extends \PHPUnit_Framework_TestCase
{

    /** @var FrontendInitResponse */
    public $t;

    /** @var MockCurlResponse */
    public $mCurlResponse;

    public function setUp()
    {
        $this->t = new FrontendInitResponse();
        $this->mCurlResponse = new MockCurlResponse();
    }

    public function testRedirectUrl()
    {
        $expected = 'foobar';
        $this->mCurlResponse->body = 'redirectUrl=' . $expected;
        $this->t->InitFromCurlResponse($this->mCurlResponse);
        $this->assertEquals($expected, $this->t->GetRedirectUrl());
    }

    public function testErrorPaySysMessage()
    {
        $expected = 'CUSTOMERID missing.';
        $this->mCurlResponse->body = 'error.1.paySysMessage=CUSTOMERID+missing.'
                . '&errors=1';
        $this->t->InitFromCurlResponse($this->mCurlResponse);
        $errors = $this->t->GetErrorArray();
        $this->assertEquals($expected, $errors[1]->GetPaySysMessage());
    }

}
