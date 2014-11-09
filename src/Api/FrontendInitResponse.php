<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class FrontendInitResponse extends Response {
            
    /**
     * URL to redirect your consumer.
     * @return string Alphanumeric
     */
    public function GetRedirectUrl() {
        return $this->Get('redirectUrl');
    }
    
}