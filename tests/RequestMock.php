<?php
namespace at\externet\WirecardCheckoutSeamless\Api;

class RequestMock extends Request
{

    public function __construct($requestUrl, $requiredOrder, $curl = null)
    {
        parent::__construct($requestUrl, $requiredOrder, $curl);
    }

    public function Set($name, $value)
    {
        parent::Set($name, $value);
    }

    public function Send($secret)
    {
        return parent::Send($secret);
    }
}