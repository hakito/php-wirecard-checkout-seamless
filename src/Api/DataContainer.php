<?php

namespace at\externet\WirecardCheckoutSeamless\Api;

abstract class DataContainer extends \at\externet\WirecardCheckoutSeamless\Utility\WellDefined
{
    private $data = array();

    protected function IsEmpty($name)
    {
        return empty($this->data[$name]);
    }

    protected function Set($name, $value)
    {
        $this->data[$name] = $value;
    }

    protected function Get($name)
    {
        if (!isset($this->data[$name]))
            return null;
        return $this->data[$name];
    }

    /** @private */
    public function &GetContainerData()
    {
        return $this->data;
    }
}