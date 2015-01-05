<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class ConfirmationResponse extends Response {

    private static $mandatoryFingerPrintFields = array(
        'paymentState', 'orderNumber', 'orderNumber'
    );

    /**
     * Initializes from data array. In case of success the fields will be
     * validated using the fingerprint and the secret.
     * @param type $data Normally you should forward the $_POST array here
     * @param type $secret Your wirecard secret
     * @throws \InvalidArgumentException when mandatory fields are missing
     * @throws InvalidFingerprintException when fingerprint validation fails
     */
    public function InitFromArray($data, $secret) {
        
        if (!isset($data['paymentState']))
        {
            throw new \InvalidArgumentException('No paymentState provided.');
        }

        $validStates = array('CANCEL', 'PENDING', 'FAILURE', 'SUCCESS');
        $paymentState = $data['paymentState'];
        if (!in_array($paymentState, $validStates))
        {
            throw new \InvalidArgumentException('Invalid paymentState "'
            . $paymentState . '".');
        }

        parent::InitFromArray($data);

        if ($this->GetPaymentState() != 'SUCCESS')
        {
            return;
        }

        $this->CheckFingerprint($secret);
    }

    /**
     *
     * @param type $secret
     * @return type
     * @throws \InvalidArgumentException
     * @throws InvalidFingerprintException
     */
    private function CheckFingerprint($secret)
    {
        foreach (self::$mandatoryFingerPrintFields as $field)
        {
            if (strlen($this->Get($field)) == 0)
            {
                throw new \InvalidArgumentException(
                    'Mandatory fields must be non-empty.'
                );
            }
        }

        $parts = explode(',', $this->GetResponseFingerprintOrder());
        $seed = '';
        $secretUsed = false;
        foreach($parts as $part)
        {
            if (strcmp($part, "secret") == 0)
            {
                $secretUsed = true;
                $seed .= $secret;
                continue;
            }

            $seed .= $this->Get($part);
        }

        $fingerPrint = hash("sha512", $seed);
        if ((strcmp($fingerPrint, $this->GetResponseFingerPrint())) == 0
            && $secretUsed)
        {
            return;
        }

        throw new InvalidFingerprintException('The verification of the '
            . 'response data was not successful.');
    }

    /**
     * Result of checkout process: “SUCCESS”, “CANCEL”, “FAILURE” or “PENDING”.
     * @return string
     */
    public function GetPaymentState() {
        return $this->Get('paymentState');
    }

    /**
     * Based on pre-selected payment method a sub-selection of financial
     * institutions regarding to pre-selected payment method.
     * @return string
     */
    public function GetFinancialInstitution()
    {
        return $this->Get('financialInstitution');
    }

    /**
     * Language used for displayed texts on payment page.
     * @return string Alphabetic with a fixed length of 2.
     */
    public function GetLanguage()
    {
        return $this->Get('language');
    }

    /**
     *
     * @return string
     */
    public function GetOrderNumber()
    {
        return $this->Get('orderNumber');
    }

    /**
     * Selected payment method of your consumer.
     * @return string
     */
    public function GetPaymentType()
    {
        return $this->Get('paymentType');
    }

    public function GetResponseFingerprintOrder()
    {
        return $this->Get('responseFingerprintOrder');
    }

    public function GetResponseFingerPrint()
    {
        return $this->Get('responseFingerprint');
    }

    /**
     * Amount of payment.
     * @return string
     */
    public function GetAmount()
    {
        return $this->Get('amount');
    }
    /**
     * Currency code of amount.
     * @return string Alphabetic with a fixed length of 3.
     */
    public function GetCurrency()
    {
        return $this->Get('currency');
    }

    /**
     * Contract number of the processor or acquirer.
     * @return string Alphanumeric with special characters with a variable
     *                length of up to 255.
     */
    public function GetGatewayContractNumber()
    {
        return $this->Get('gatewayContractNumber');
    }

    /**
     * Reference number of the processor or acquirer.
     * @return string Alphanumeric with special characters with a variable
     *                length of up to 255.
     */
    public function GetGatewayReferenceNumber()
    {
        return $this->Get('gatewayReferenceNumber');
    }

    /**
     * Error text describing the failure.
     * @return string Alphanumeric with special characters.
     */
    public function GetMessage()
    {
        return $this->Get('message');
    }

}