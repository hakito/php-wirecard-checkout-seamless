<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'MockCurlResponse.php';

class MockResponse extends Response
{
    public function Get($name)
    {
        return parent::Get($name);
    }
}

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockResponse */
    public $t;

    public function setUp()
    {
        $this->t = new MockResponse();
    }

    public function testInitFromCurlResponse()
    {
        // Given
        $curlResponse = new MockCurlResponse();
        $curlResponse->body = 'storageId=myStorage&javascriptUrl=jsUrl';

        // When
        $this->t->InitFromCurlResponse($curlResponse);

        // Then
        $this->assertEquals($this->t->Get('storageId'), 'myStorage');
        $this->assertEquals($this->t->Get('javascriptUrl'), 'jsUrl');
    }

    public function testInitFromCurlResponseArray()
    {
         // Given
        $curlResponse = new MockCurlResponse();
        $curlResponse->body = 'a.1.b=foo&a.1.c=bar';

        // When
        $this->t->InitFromCurlResponse($curlResponse);

        // Then
        $expected = array('1' => array('b' => 'foo', 'c' => 'bar'));
        $this->assertEquals($expected, $this->t->Get('a'));

    }

    public function testErrorCountNoErrors()
    {
        // Given
        $curlResponse = new MockCurlResponse();
        $this->t->InitFromCurlResponse($curlResponse);

        // When
        $actual = $this->t->GetErrors();

        // Then
        
        $this->assertTrue(is_numeric($actual));
        $this->assertEquals(0, $actual);
    }

    public function testErrorCount()
    {
        // Given
        $curlResponse = new MockCurlResponse();
        $curlResponse->body = 'errors=5';
        $this->t->InitFromCurlResponse($curlResponse);

        // When
        $actual = $this->t->GetErrors();

        // Then
        $this->assertEquals(5, $actual);
    }

    public function testErrorArray()
    {
        // Given
        $curlResponse = new MockCurlResponse();
        $curlResponse->body = 'error.1.errorCode=11500'
                . '&error.1.message=CUSTOMERID+is+missing.'
                . '&error.2.errorCode=11009'
                . '&error.2.message=Language+is+missing.'
                . '&errors=2';
        $this->t->InitFromCurlResponse($curlResponse);

        // When
        $actual = $this->t->GetErrorArray();

        // Then
        $e1 = array(
            'errorCode' => '11500',
            'message' => 'CUSTOMERID is missing.'
        );
        
        $e2 = array(
            'errorCode' => '11009',
            'message' => 'Language is missing.'
        );
        
        $this->assertTrue(is_numeric($actual[1]->GetCode()));
        $this->assertEquals($e1, $actual[1]->GetContainerData());
        $this->assertEquals($e2, $actual[2]->GetContainerData());
    }
}