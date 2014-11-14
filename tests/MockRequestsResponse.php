<?php

namespace at\externet\WirecardCheckoutSeamless\Api;
require_once __DIR__ . DIRECTORY_SEPARATOR . 'MockTransport.php';


class MockRequests_Response extends \Requests_Response {
    public function __construct() {}
}