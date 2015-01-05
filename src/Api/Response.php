<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

abstract class Response extends DataContainer {

    public function InitFromArray($data)
    {
        foreach ($data as $key => $val)
        {
            $keyParts = explode('.', $key);

            // Splitting keyparts also by underscore because of a possible failure in the wirecard documentation
            // https://integration.wirecard.at/doku.php/response_parameters#response_parameters_which_will_be_returned_in_case_of_a_failure
            // The errors in ConfirmationResponse seem to be separated by underscores.
            if (sizeof($keyParts) == 1)
                $keyParts = explode ('_', $key);

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
     * @param \Requests_Response $requestsResponse
     */
    public function InitFromHttpResponse($requestsResponse) {
        $parts = explode('&', $requestsResponse->body);
        $dataArray = array();

        foreach ($parts as &$part)
        {
            $pair = explode('=', $part);
            if (sizeof($pair) != 2)
                continue;

            $dataArray[urldecode($pair[0])] = urldecode($pair[1]);
        }

        $this->InitFromArray($dataArray);
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
        if ($this->IsEmpty('error'))
            return array();
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