<?php
namespace App\Sms;

use App\Consts\SmsProvidersConsts;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SecondProvider implements ISmsProvider
{

    public function send()
    {
        try {
            $response = Http::get(SmsProvidersConsts::SECOND);

            if ($response->status() != 200) {
                Log::error("second sms provider has issue");
            }
        } catch (Exception $e) {
            Log::error("second sms provider is down");
        }
    }
}
