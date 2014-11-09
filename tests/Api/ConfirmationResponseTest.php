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
            '\InvalidArgumentException',
            'Mandatory fields must be non-empty.');
        $this->t->InitFromArray(array('paymentState' => 'SUCCESS'), '');
    }

    public function testInitFromArrayInvalidMandatory2()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            'Mandatory fields must be non-empty.');
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
            'at\externet\WirecardCheckoutSeamless\Api\InvalidFingerprintException',
            'The verification of the response data was not successful.');

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
            'at\externet\WirecardCheckoutSeamless\Api\InvalidFingerprintException',
            'The verification of the response data was not successful.');
        
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

}