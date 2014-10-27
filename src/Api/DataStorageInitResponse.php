<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

class DataStorageInitResponse extends Response {
            
    /**
     * Unique reference of the data storage for a consumer.
     * @return string Alphanumeric with a fixed length of 32. 
     */
    public function GetStroageId() {
        return $this->Get('storageId');
    }

    /**
     * URL to a JavaScript resource which have to be included for
     * using the storage operations of the data storage.
     * @return string
     */
    public function GetJavascriptUrl() {
        return $this->Get('javascriptUrl');
    }
}