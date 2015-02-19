<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'RequestMock.php';

class RequestTest extends \PHPUnit_Framework_TestCase
{

    /** @var Request */
    private $t;

    /** @var MockTransport */
    private $mTransport;

    public function setUp()
    {
        $this->mTransport = new MockTransport();
        $this->t = new RequestMock('http://localhost', array('first' => false, 'second' => true), $this->mTransport);
    }

    public function testSendRequest()
    {
        // Given
        $mRequest = new RequestMock('https://example.com', array('first' => true), $this->mTransport);
        $mRequest->Set('first', 'foo');
        $this->mTransport->body = 'RequestResponse';

        // When
        $actual = $mRequest->Send('secret');

        // Then
        $this->assertEquals('RequestResponse', $actual->body);
    }

    public function testGetParametersMissing()
    {
        $this->setExpectedException('at\externet\WirecardCheckoutSeamless\Api\MissingRequiredParameterException', "Missing required parameter 'second'.");
        $this->t->GetParameters();
    }

    public function testGetParameterOrder()
    {
        $this->t->Set('second', 'two');
        $this->t->Set('first', 'one');
        $actual = $this->t->GetParameters();
        $expected = array('first' => 'one', 'second' => 'two');
        $this->assertEquals($actual, $expected);
    }

    public function testGetParameterSkipMissing()
    {
        $this->t->Set('second', 'one');
        $actual = $this->t->GetParameters();
        $expected = array('second' => 'one');
        $this->assertEquals($actual, $expected);
    }

    public function testComputeFingerprint()
    {
        $t = $this->getMockBuilder('at\externet\WirecardCheckoutSeamless\Api\Request')
                ->disableOriginalConstructor()
                ->setMethods(array('GetParameters'))
                ->getMock();
        $t->expects($this->once())
                ->method('GetParameters')
                ->will($this->returnValue(array('a' => 'b')));

        $actual = $t->ComputeFingerprint('secret');
        $expected = hash("sha512", 'b' . 'secret');
        $this->assertEquals($expected, $actual);
    }

    public function testGetParametersWithFingerprint()
    {
        $t = $this->getMockBuilder('at\externet\WirecardCheckoutSeamless\Api\Request')
                ->disableOriginalConstructor()
                ->setMethods(array('ComputeFingerprint', 'GetParameters'))
                ->getMock();
        $t->expects($this->once())
                ->method('ComputeFingerprint')
                ->will($this->returnValue('thumb'));
        $t->expects($this->once())
                ->method('GetParameters')
                ->will($this->returnValue(array('first' => 'one')));

        $actual = $t->GetParametersWithFingerprint('secret');
        $expected = array('first' => 'one', 'requestFingerprint' => 'thumb');
        $this->assertEquals($expected, $actual);
    }

    public function testGetRequestUrl()
    {
        $actual = $this->t->GetRequestUrl();
        $this->assertEquals('http://localhost', $actual);
    }

}
