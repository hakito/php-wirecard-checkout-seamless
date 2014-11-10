<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class FrontendInitRequestTest extends \PHPUnit_Framework_TestCase
{

    /** @var FrontendInitRequest */
    private $t;
    private $mCurl;

    public function setUp()
    {
        $this->mCurl = $this->getMock('Curl');
        $this->t = new FrontendInitRequest($this->mCurl);
    }

    public function testSendMissingParameters()
    {
        $this->setExpectedException('at\externet\WirecardCheckoutSeamless\Api\MissingRequiredParameterException');
        $this->t->Send('secret');
    }

    public function testSendReturnsResponse()
    {
        $this->t->SetCustomerId('D200001');
        $this->t->SetLanguage('de');
        $this->t->SetPaymentType('CCARD');
        $this->t->SetAmount('30.0');
        $this->t->SetCurrency('EUR');
        $this->t->SetOrderDescription('Test order');
        $this->t->SetSuccessUrl('http://success.url');
        $this->t->SetCancelUrl('http://cancel.url');
        $this->t->SetFailureUrl('http://failure.url');
        $this->t->SetServiceUrl('http://service.url');
        $this->t->SetConfirmUrl('http://confirm.url');
        $this->t->SetConsumerIpAddress('127.0.0.1');
        $this->t->SetConsumerUserAgent('FooZilla');

        $actual = $this->t->Send('secret');

        $this->assertInstanceOf('at\externet\WirecardCheckoutSeamless\Api\FrontendInitResponse', $actual);
    }

    public function testGetRequestFingerprintOrder()
    {
        $actual = $this->t->GetRequestFingerPrintOrder();
        $expected = 'customerId,language,paymentType,amount,currency,'
                . 'orderDescription,successUrl,cancelUrl,failureUrl,serviceUrl,'
                . 'confirmUrl,consumerIpAddress,consumerUserAgent,'
                . 'requestFingerprintOrder,financialInstitution,pendingUrl,'
                . 'noScriptInfoUrl,orderNumber,windowName,'
                . 'duplicateRequestCheck,customerStatement,orderReference,'
                . 'transactionIdentifier,orderIdent,storageId';

        $this->assertEquals($expected, $actual);
    }

    public function testGettersAndSetters()
    {
        $this->AssertGetterAndSetter('customerId');
        $this->AssertGetterAndSetter('language');
        $this->AssertGetterAndSetter('paymentType');
        $this->AssertGetterAndSetter('amount');
        $this->AssertGetterAndSetter('currency');
        $this->AssertGetterAndSetter('orderDescription');
        $this->AssertGetterAndSetter('successUrl');
        $this->AssertGetterAndSetter('cancelUrl');
        $this->AssertGetterAndSetter('failureUrl');
        $this->AssertGetterAndSetter('serviceUrl');
        $this->AssertGetterAndSetter('confirmUrl');
        $this->AssertGetterAndSetter('consumerIpAddress');
        $this->AssertGetterAndSetter('financialInstitution');
        $this->AssertGetterAndSetter('pendingUrl');
        $this->AssertGetterAndSetter('noScriptInfoUrl');
        $this->AssertGetterAndSetter('orderNumber');
        $this->AssertGetterAndSetter('windowName');
        $this->AssertGetterAndSetter('duplicateRequestCheck');
        $this->AssertGetterAndSetter('customerStatement');
        $this->AssertGetterAndSetter('orderReference');
        $this->AssertGetterAndSetter('transactionIdentifier');
        $this->AssertGetterAndSetter('orderIdent');
        $this->AssertGetterAndSetter('storageId');
    }

    private function AssertGetterAndSetter($field, $value = 'v')
    {
        $pascalCase = strtoupper(substr($field,0,1)) . substr($field, 1);
        $getter = 'Get' . $pascalCase;
        $setter = 'Set' . $pascalCase;
        $this->AssertNull($this->t->$getter());
        $this->t->$setter($value);
        $this->AssertEquals($value, $this->t->$getter());
    }

}
