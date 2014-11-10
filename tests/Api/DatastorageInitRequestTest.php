<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class DataStorageInitRequestTest extends \PHPUnit_Framework_TestCase
{

    /** @var DataStorageInitRequest */
    private $t;

    private $mCurl;

    public function setUp()
    {
        $this->mCurl = $this->getMock('Curl');
        $this->t = new DataStorageInitRequest($this->mCurl);
    }

    public function testOrderIdent()
    {
        $this->t->SetOrderIdent('foo');
        $this->assertEquals('foo', $this->t->GetOrderIdent());
    }

    public function testReturnUrl()
    {
        $this->t->SetReturnUrl('foo');
        $this->assertEquals('foo', $this->t->GetReturnUrl());
    }

    public function testShopId()
    {
        $this->t->SetShopId('foo');
        $this->assertEquals('foo', $this->t->GetShopId());
    }

    public function testJavascriptScriptVersion()
    {
        $this->t->SetJavascriptScriptVersion('foo');
        $this->assertEquals('foo', $this->t->GetJavascriptScriptVersion());
    }

    public function testGetParametersMissingRequired()
    {
        $this->setExpectedException('at\externet\WirecardCheckoutSeamless\Api\MissingRequiredParameterException');
        $this->t->GetParameters();
    }

    public function testGetParametersOrder()
    {
        $this->t->SetShopId('myShop');
        $this->t->SetJavascriptScriptVersion('jVersion');
        $this->t->SetCustomerId('merchantId');
        $this->t->SetOrderIdent('orderIdent');
        $this->t->SetReturnUrl('returnUrl');
        $this->t->SetLanguage('mylang');
        $actual = $this->t->GetParameters();
        $expected = array(
            'customerId' => 'merchantId',
            'shopId' => 'myShop',
            'orderIdent' => 'orderIdent',
            'returnUrl' => 'returnUrl',
            'language' => 'mylang',
            'javascriptScriptVersion' => "jVersion",
        );
        $this->assertEquals($expected, $actual);
    }

    public function testSendMissingParameter()
    {
        $this->setExpectedException('at\externet\WirecardCheckoutSeamless\Api\MissingRequiredParameterException');
        $this->t->Send('topSecret');
    }

    public function testSendReturnsResponse()
    {
        $mResponse = new \CurlResponse("");
        $this->mCurl->expects($this->once())
                ->method('post')
                ->will($this->returnValue($mResponse));
        $this->t->SetShopId('myShop');
        $this->t->SetJavascriptScriptVersion('jVersion');
        $this->t->SetCustomerId('merchantId');
        $this->t->SetOrderIdent('orderIdent');
        $this->t->SetReturnUrl('returnUrl');
        $this->t->SetLanguage('mylang');
        $actual = $this->t->Send('topSecret');

        $this->assertInstanceOf('at\externet\WirecardCheckoutSeamless\Api\DataStorageInitResponse', $actual);
    }
}
