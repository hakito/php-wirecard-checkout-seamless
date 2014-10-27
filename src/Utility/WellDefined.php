<?php

namespace at\externet\WirecardCheckoutSeamless\Utility;

abstract class WellDefined
{
    public function __set($name, $value)
    {
        throw new PropertyUndefinedException($name);
    }

    public function __get($name)
    {
        throw new PropertyUndefinedException($name);
    }
}