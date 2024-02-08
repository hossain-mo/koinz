<?php

namespace App\Jobs;

use App\Services\BookCalculationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateInterval implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $newInterval;
    public function __construct(array $newInterval)
    {
        $this->queue = 'calculate';
        $this->newInterval = $newInterval;
    }

    public function handle(BookCalculationService $bookCalculationService): void
    {

        $bookCalculationService->createOrUpdate($this->newInterval);

    }
}
