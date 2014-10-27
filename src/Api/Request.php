<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

abstract class Request extends DataContainer
{
    private $requiredOrder;
    private $requestUrl;

    /** @var \Curl */
    private $curl;

    public function __construct($requestUrl, $requiredOrder, $curl = null)
    {
        $this->requestUrl = $requestUrl;
        $this->requiredOrder = $requiredOrder;
        $this->curl = $curl == null ? new \Curl() : $curl;
        $this->curl->options = array(
            'PORT' => 443,
            'PROTOCOLS' => CURLPROTO_HTTPS,
            'SSL_VERIFYPEER' => true
        );
    }

    protected function Send($secret) {
        return $this->curl->post(
            $this->GetRequestUrl(),
            $this->GetParametersWithFingerprint($secret));
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
            $empty = parent::IsEmpty($key);
            if ($val && $empty)
                throw new MissingRequiredParameterException("Missing required parameter '$key'.");

            if (!$empty)
                $ret[$key] = parent::Get($key);
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
