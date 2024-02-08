<?php
namespace App\Sms;

use App\Consts\SmsProvidersConsts;
use Exception;

class SmsProviderFactory
{

    public function getCurrentPrivider()
    {
        $providerKey = env('SMS_GATEWAY');

        $supportedKeys = array_keys(SmsProvidersConsts::getConstants());

        if (in_array(strtoupper($providerKey), $supportedKeys)) {

            $classString = ucfirst($providerKey) . 'Provider';

            $formattedString = sprintf('App\\Sms\\%s', $classString);

            $instance = new $formattedString();

            return $instance;
        }

        throw new Exception("UnSupported Sms Provider");

    }
}
