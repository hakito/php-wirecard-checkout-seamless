<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class ConfirmationResponseTest extends \PHPUnit_Framework_TestCase
{

    /** @var ConfirmationResponse */
    public $t;

    public function setUp()
    {
        $this->t = new ConfirmationResponse();
    }

    public function testInitFromArrayEmpty()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $this->t->InitFromArray(array(), '');
    }

    public function testInitFromArrayCancel()
    {
        $this->t->InitFromArray(array('paymentState' => 'CANCEL'), '');
        $actual = $this->t->GetPaymentState();
        $this->assertEquals('CANCEL', $actual);
    }

    public function testInitFromArrayInvalidPaymentState()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $this->t->InitFromArray(array('paymentState' => 'FOO'), '');
    }

    public function testInitFromArrayInvalidMandatory1()
    {
        $this->setExpectedException(
                '\InvalidArgumentException', 'Mandatory fields must be non-empty.');
        $this->t->InitFromArray(array('paymentState' => 'SUCCESS'), '');
    }

    public function testInitFromArrayInvalidMandatory2()
    {
        $this->setExpectedException(
                '\InvalidArgumentException', 'Mandatory fields must be non-empty.');
        $data = array(
            'paymentState' => 'SUCCESS',
            'orderNumber' => '',
            'paymentType' => '',
        );

        $this->t->InitFromArray($data, '');
    }

    public function testInitFromArrayInvalidFingerprint()
    {
        $this->setExpectedException(
                'at\externet\WirecardCheckoutSeamless\Api\InvalidFingerprintException', 'The verification of the response data was not successful.');

        $data = array(
            'paymentState' => 'SUCCESS',
            'orderNumber' => 'a',
            'paymentType' => 'b',
            'responseFingerprintOrder' => 'paymentState,orderNumber,secret,paymentType',
            'responseFingerprint' => 'invalidFingerprint'
        );

        $this->t->InitFromArray($data, '');
    }

    public function testInitFromArrayNoSecretInFingerprint()
    {
        $this->setExpectedException(
                'at\externet\WirecardCheckoutSeamless\Api\InvalidFingerprintException', 'The verification of the response data was not successful.');

        $data = array(
            'paymentState' => 'SUCCESS',
            'orderNumber' => 'a',
            'paymentType' => 'b',
            // No secret in responseFingerprintOrder:
            'responseFingerprintOrder' => 'paymentState,orderNumber,paymentType',
            'responseFingerprint' => hash("sha512", 'SUCCESSab')
        );

        $this->t->InitFromArray($data, 'TopSecret');
    }

    public function testInitFromArrayValidFingerprint()
    {

        $data = array(
            'paymentState' => 'SUCCESS',
            'orderNumber' => 'a',
            'paymentType' => 'b',
            'responseFingerprintOrder' => 'paymentState,orderNumber,secret,paymentType',
            'responseFingerprint' => hash("sha512", 'SUCCESSaTopSecretb')
        );

        $this->t->InitFromArray($data, 'TopSecret');
    }

    public function testInitFromArrayWithErrors()
    {
        $data = array(
            'paymentState' => 'FAILURE',
            'orderNumber' => 'a',
            'paymentType' => 'b',
            'error.1.message' => 'Err Message',
            'error.1.consumerMessage' => 'Err ConsumerMessage',
            'error.1.paySysMessage' => 'Err PaySysMessage',
            'errors' => '1',
            'responseFingerprintOrder' => 'paymentState,orderNumber,secret,paymentType',
            'responseFingerprint' => hash("sha512", 'FAILUREaTopSecretb')
        );

        $this->t->InitFromArray($data, 'TopSecret');
        $errors = $this->t->GetErrorArray();

        $this->assertEquals(1, $this->t->GetErrors());
        $this->assertEquals('Err PaySysMessage', $errors[1]->GetPaySysMessage());
    }

    public function testGetters()
    {
        $container = &$this->t->GetContainerData();
        $container['paymentState'] = 'a';
        $container['financialInstitution'] = 'b';
        $container['language'] = 'c';
        $container['orderNumber'] = 'd';
        $container['paymentType'] = 'e';
        $container['responseFingerprint'] = 'f';
        $container['responseFingerprintOrder'] = 'g';
        $container['amount'] = 'h';
        $container['currency'] = 'i';
        $container['gatewayContractNumber'] = 'j';
        $container['gatewayReferenceNumber'] = 'k';
        $container['message'] = 'l';

        $this->AssertEquals('a', $this->t->GetPaymentState());
        $this->AssertEquals('b', $this->t->GetFinancialInstitution());
        $this->AssertEquals('c', $this->t->GetLanguage());
        $this->AssertEquals('d', $this->t->GetOrderNumber());
        $this->AssertEquals('e', $this->t->GetPaymentType());
        $this->AssertEquals('f', $this->t->GetResponseFingerPrint());
        $this->AssertEquals('g', $this->t->GetResponseFingerprintOrder());
        $this->AssertEquals('h', $this->t->GetAmount());
        $this->AssertEquals('i', $this->t->GetCurrency());
        $this->AssertEquals('j', $this->t->GetGatewayContractNumber());
        $this->AssertEquals('k', $this->t->GetGatewayReferenceNumber());
        $this->AssertEquals('l', $this->t->GetMessage());
    }

}
