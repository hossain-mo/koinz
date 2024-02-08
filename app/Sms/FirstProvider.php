<?php
namespace App\Sms;

use App\Consts\SmsProvidersConsts;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirstProvider implements ISmsProvider
{

    public function send()
    {
        try {
            $response = Http::get(SmsProvidersConsts::FIRST);

            if ($response->status() != 200) {
                Log::error("first sms provider has issue");
            }
        } catch (Exception $e) {
            Log::error("first sms provider is down");
        }
    }
}
