<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class DataStorageInitRequest extends Request
{

    public function __construct()
    {
        $requiredOrder = array(
            'customerId' => true,
            'shopId' => false,
            'orderIdent' => true,
            'returnUrl' => true,
            'language' => true,
            'javascriptScriptVersion' => false
        );
        parent::__construct('https://checkout.wirecard.com/seamless/dataStorage/init', $requiredOrder);
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
     * Unique reference to the order of your consumer.
     * @param string $value Alphanumeric
     */
    public function SetOrderIdent($value)
    {
        $this->Set('orderIdent', $value);
    }

    /**
     * Unique reference to the order of your consumer.
     * @return string
     */
    public function GetOrderIdent()
    {
        return $this->Get('orderIdent');
    }

    /**
     * Return URL for outdated browsers.
     * @param string $value Alphanumeric
     */
    public function SetReturnUrl($value)
    {
        $this->Set('returnUrl', $value);
    }

    /**
     * Return URL for outdated browsers.
     * @return string
     */
    public function GetReturnUrl()
    {
        return $this->Get('returnUrl');
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

    /**
     * Unique ID of your web shop.
     * @param string $value Alphanumeric with a variable length of 16.
     */
    public function SetShopId($value)
    {
        $this->Set('shopId', $value);
    }

    /**
     * Unique ID of your web shop.
     * @return string
     */
    public function GetShopId()
    {
        return $this->Get('shopId');
    }

    /**
     * Version number of JavaScript.
     * @param Number $value Numeric
     */
    public function SetJavascriptScriptVersion($value)
    {
        $this->Set('javascriptScriptVersion', $value);
    }

    /**
     * Version number of JavaScript.
     * @return Number
     */
    public function GetJavascriptScriptVersion()
    {
        return $this->Get('javascriptScriptVersion');
    }

    /**
     *
     * @param string $secret
     * @return \at\externet\WirecardCheckoutSeamless\Api\DataStorageInitResponse
     */
    public function Send($secret)
    {
        $response = new DataStorageInitResponse();
        $response->InitFromCurlResponse(parent::Send($secret));
        return $response;
    }

}
