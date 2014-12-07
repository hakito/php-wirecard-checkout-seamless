<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class FrontendInitRequestTest extends \PHPUnit_Framework_TestCase
{

    /** @var FrontendInitRequest */
    private $t;
    private $mTransport;

    public function setup()
    {
        $this->mTransport = new \MockTransport();
        $this->t = new FrontendInitRequest($this->mTransport);
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
                . 'confirmUrl,consumerIpAddress,consumerUserAgent,requestFingerprintOrder'
                . ',secret'; // allways contains a secret

        $this->assertEquals($expected, $actual);
    }

    public function testGetRequestFingerprintOrderWithOptionalParameter()
    {
        $this->t->SetStorageId('fooBar');
        $actual = $this->t->GetRequestFingerPrintOrder();

        $this->assertContains('storageId', $actual);
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
        $this->AssertGetterAndSetter('consumerUserAgent');
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

        // Optional parameters enabled by Wirecard on your behalf
        $this->AssertGetterAndSetter('autoDeposit');
        $this->AssertGetterAndSetter('confirmMail');
        $this->AssertGetterAndSetter('shopId');
    }

    public function testGetParameters()
    {
        $container = &$this->t->GetContainerData();
        $fingerprintOrder = $this->t->GetRequestFingerPrintOrder();
        $staticParams = explode(',', str_replace(',requestFingerprintOrder', '', $fingerprintOrder));
        foreach($staticParams as $staticParam)
            $container[$staticParam] = $staticParam;

        $actual = $this->t->GetParameters();
        $this->assertContains('requestFingerprintOrder', array_keys($actual));
        $this->assertNotEmpty($actual['requestFingerprintOrder']);
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
