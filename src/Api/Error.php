<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class Error extends DataContainer
{
    public function GetCode() {
        return $this->Get('errorCode');
    }

    public function GetMessage() {
        return $this->Get('message');
    }

    public function GetConsumerMessage() {
        return $this->Get('consumerMessage');
    }
}