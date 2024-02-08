<?php

namespace App\Consts;

use ReflectionClass;

class SmsProvidersConsts
{
    public const FIRST = "https://run.mocky.io/v3/8eb88272-d769-417c-8c5c-159bb023ec0a";

    public const SECOND = "https://run.mocky.io/v3/268d1ff4-f710-4aad-b455-a401966af719";

    public static function getConstants()
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getConstants();
    }
}
