<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

abstract class Response extends DataContainer {

    /**
     *
     * @param \CurlResponse $curlResponse
     */
    public function InitFromCurlResponse($curlResponse) {
        $parts = explode('&', $curlResponse->body);
        foreach ($parts as &$part)
        {
            $pair = explode('=', $part);
            if (sizeof($pair) != 2)
                continue;

            $key = urldecode($pair[0]);
            $val = urldecode($pair[1]);
            $keyParts = explode('.', $key);
            if (sizeof($keyParts) == 1)
                $this->Set($key, $val);
            else
            {
                $key = $k = array_shift($keyParts);
                $target = $this->IsEmpty($k) ? array() : $this->Get($k);
                $t = &$target;

                while(true)
                {
                    $k = array_shift($keyParts);
                    if (is_null($k))
                        break;

                    if (!isset($t[$k]))
                        $t[$k] = null;
                    $t = &$t[$k];
                }
                
                $t = $val;
                $this->Set($key, $target);
            }
        }
    }

    /**
     *
     * @return int Number of errors occurred.
     */
    public function GetErrors()
    {
        return (int) $this->Get('errors');
    }

    /**
     *
     * @return \at\externet\WirecardCheckoutSeamless\Api\Error[] 
     */
    public function GetErrorArray()
    {
     //   if ($this->IsEmpty('error'))
     //       return array();
        $ret = array();
        foreach ($this->Get('error') as $key => $errorData)
        {
            $err = new Error();
            $ret[$key] = $err;
            foreach($errorData as $field => &$val)
                $err->Set($field, $val);
        }
        return $ret;
    }
}