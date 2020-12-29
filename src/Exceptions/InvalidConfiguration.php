<?php

namespace Alyka\SmartSMS\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    /**
     * @return static
     */
    public static function configurationNotSet()
    {
        return new static('In order to send notification via SmartSMS you need to add credentials in the `smart_sms` key of `config.services`.');
    }
}
