<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class Error extends DataContainer
{
    /**
     * Numeric error code which you should log for later use.
     * @return string Numeric with a fixed length of 5.
     */
    public function GetCode() {
        return $this->Get('errorCode');
    }

    /**
     * Error message in English.
     * @return string Alphanumeric with special characters.
     */
    public function GetMessage() {
        return $this->Get('message');
    }

    /**
     * Error message in localized language for your consumer.
     * @return string Alphanumeric with special characters.
     */
    public function GetConsumerMessage() {
        return $this->Get('consumerMessage');
    }

    /**
     * Payment method system specific error message only relevant for merchant.
     * @return string Alphanumeric with special characters.
     */
    public function GetPaySysMessage() {
        return $this->Get('paySysMessage');
    }
}