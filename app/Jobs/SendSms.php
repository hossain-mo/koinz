<?php

namespace App\Jobs;

use App\Sms\SmsProviderFactory;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        $this->queue = 'sms';
    }

    public function handle(SmsProviderFactory $smsProviderFactory): void
    {
        try {

            $provider = $smsProviderFactory->getCurrentPrivider();

            $provider->send();

        } catch (Exception $e) {

            throw $e;
        }
    }
}
