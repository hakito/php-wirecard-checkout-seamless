<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'RequestMock.php';

class RequestTest extends \PHPUnit_Framework_TestCase
{

    /** @var Request */
    private $t;

    private $mCurl;

    public function setUp()
    {
        $this->mCurl = $this->getMock('Curl');
        $this->t = new RequestMock('http://localhost', array('first' => false, 'second' => true), $this->mCurl);
    }

    public function testCurlOpts()
    {
        // When
        //$t = new RequestMock($this->mCurl);

        // Then
        $expected = array(
            'PORT' => 443,
            'PROTOCOLS' => CURLPROTO_HTTPS,
            'SSL_VERIFYPEER' => true
        );
        $this->assertEquals($expected, $this->mCurl->options);
    }

    public function testSendRequest()
    {
        // Given
        $mRequest = new RequestMock('url', array('first' => true), $this->mCurl);
        $mRequest->Set('first', 'foo');
        $this->mCurl->expects($this->once())
                ->method('post')
                ->with('url', $mRequest->GetParametersWithFingerprint('secret'), null)
                ->will($this->returnValue('curlResponse'));

        // When
        $actual = $mRequest->Send('secret');

        // Then
        $this->assertEquals('curlResponse', $actual);
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
