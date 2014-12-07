<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

abstract class Request extends DataContainer
{
    protected $requiredOrder;
    private $requestUrl;

    /** @var \Requests_Transport */
    private $transport;

    public function __construct($requestUrl, $requiredOrder, $transport = null)
    {
        $this->transport = $transport;
        $this->requestUrl = $requestUrl;
        $this->requiredOrder = $requiredOrder;
    }

    protected function Send($secret) {
        $options = $this->transport === null ? array() : array(
                'transport' => $this->transport
            );
        return \Requests::post(
                $this->GetRequestUrl(),
                array(),
                $this->GetParametersWithFingerprint($secret),
                $options);
    }

    public function GetRequestUrl()
    {
        return $this->requestUrl;
    }

    public function GetParameters()
    {
        $ret = array();
        foreach($this->requiredOrder as $key => $val)
        {
            $empty = $this->IsEmpty($key);
            if ($val && $empty)
                throw new MissingRequiredParameterException("Missing required parameter '$key'.");

            if (!$empty)
                $ret[$key] = $this->Get($key);
        }
        return $ret;
    }

    public function ComputeFingerprint($secret)
    {
        $parameters = $this->GetParameters();
        $seed = join('', $parameters);
        $seed .= $secret;
        return hash("sha512", $seed);
    }

    public function GetParametersWithFingerprint($secret)
    {
        $fingerPrint = $this->ComputeFingerprint($secret);
        $parameters = $this->GetParameters();
        $parameters['requestFingerprint'] = $fingerPrint;
        return $parameters;
    }

}
