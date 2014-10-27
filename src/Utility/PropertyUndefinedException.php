<?php

namespace at\externet\WirecardCheckoutSeamless\Utility;

class PropertyUndefinedException extends \Exception
{
    public $Property;

    public function __construct($property)
    {
        $message = "Property '" . $property . "' is undefined.";
        parent::__construct($message);
        $this->Property = $property;
    }
}