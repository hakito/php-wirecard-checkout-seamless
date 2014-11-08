<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

abstract class WirecardRequest extends Request
{

    public function __construct($requestUrl, $requiredOrder, $curl = null)
    {
        parent::__construct('https://checkout.wirecard.com/seamless/dataStorage/init', $requiredOrder, $curl);
    }

    /**
     * Unique ID of merchant.
     * @param string $value Alphanumeric with a fixed length of 7.
     */
    public function SetCustomerId($value)
    {
        $this->Set('customerId', $value);
    }

    /**
     * Unique ID of merchant.
     * @return string
     */
    public function GetCustomerId()
    {
        return $this->Get('customerId');
    }

    /**
     * Language for returned texts and error messages.
     * @param string $value Alphabetic with a fixed length of 2.
     */
    public function SetLanguage($value)
    {
        $this->Set('language', $value);
    }

    /**
     * Language for returned texts and error messages.
     * @return string 
     */
    public function GetLanguage()
    {
        return $this->Get('language');
    }

}
