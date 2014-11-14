<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'MockRequestsResponse.php';

class FrontendInitResponseTest extends \PHPUnit_Framework_TestCase
{

    /** @var FrontendInitResponse */
    public $t;

    /** @var MockRequests_Response */
    public $mRequests_Response;

    public function setUp()
    {
        $this->t = new FrontendInitResponse();
        $this->mRequests_Response = new MockRequests_Response();
    }

    public function testRedirectUrl()
    {
        $expected = 'foobar';
        $this->mRequests_Response->body = 'redirectUrl=' . $expected;
        $this->t->InitFromHttpResponse($this->mRequests_Response);
        $this->assertEquals($expected, $this->t->GetRedirectUrl());
    }

    public function testErrorPaySysMessage()
    {
        $expected = 'CUSTOMERID missing.';
        $this->mRequests_Response->body = 'error.1.paySysMessage=CUSTOMERID+missing.'
                . '&errors=1';
        $this->t->InitFromHttpResponse($this->mRequests_Response);
        $errors = $this->t->GetErrorArray();
        $this->assertEquals($expected, $errors[1]->GetPaySysMessage());
    }

}
