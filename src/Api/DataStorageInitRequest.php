<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class DataStorageInitRequest extends WirecardRequest
{

    public function __construct($transport = null)
    {
        $requiredOrder = array(
            'customerId' => true,
            'shopId' => false,
            'orderIdent' => true,
            'returnUrl' => true,
            'language' => true,
            'javascriptScriptVersion' => false
        );
        parent::__construct('https://checkout.wirecard.com/seamless/dataStorage/init', $requiredOrder, $transport);
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
     * Is used for browsers who are not capable of fully supporting
     * CORS (Cross Origin Resource Sharing). In that case the communciation
     * between the HTML page and the Wirecard Checkout Platform will be done
     * within an iframe where the anonymized payment data is returned to
     * JavaScript objects. This return URL is called by the browser of your
     * consumer.
     *
     * You should point the URL to Frontend/CorsFallback.php
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
        $response->InitFromHttpResponse(parent::Send($secret));
        return $response;
    }

}
