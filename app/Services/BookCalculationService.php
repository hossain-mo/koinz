<?php

namespace App\Services;

use App\Jobs\CalculateInterval;
use App\Jobs\SendSms;
use App\Models\BookCalculation;
use App\Repositories\BookCalculationRepo;

class BookCalculationService
{
    protected $bookCalculationRepo;

    public function __construct(BookCalculationRepo $bookCalculationRepo)
    {
        $this->bookCalculationRepo = $bookCalculationRepo;
    }

    public function get(): array
    {
        return $this->bookCalculationRepo->get();
    }

    public function create(array $data)
    {
        SendSms::dispatch();
        CalculateInterval::dispatch($data);
    }

    public function createOrUpdate(array $data): void
    {
        $oldBookCalculation = $this->bookCalculationRepo->findByBookId($data['book_id']);

        if ($oldBookCalculation) {
            $newIntervals = $this->calculateIntervals($oldBookCalculation, $data);
            $numOfReadPages = $this->calculateTotalDifference($newIntervals);

            $data['num_of_read_pages'] = $numOfReadPages;
            $data['intervals'] = json_encode($newIntervals);

            $this->bookCalculationRepo->update($oldBookCalculation->id, $data);
        } else {
            $data['num_of_read_pages'] = $data['end_page'] - $data['start_page'];
            $data['intervals'] = json_encode([['start_page' => $data['start_page'], 'end_page' => $data['end_page']]]);

            $this->bookCalculationRepo->create($data);
        }
    }

    private function calculateIntervals(BookCalculation $oldBookCalculation, array $newInterval): array
    {
        $intervals = json_decode($oldBookCalculation->intervals, true);

        foreach ($intervals as &$interval) {
            [$isStartInRange, $isEndInRange] = $this->setStartAndEndRanges($interval, $newInterval);

            if ($isStartInRange && $isEndInRange) {
                break;
            }

            if ($isStartInRange && !$isEndInRange) {
                $interval['end_page'] = $newInterval['end_page'];
                break;
            } elseif (!$isStartInRange && $isEndInRange) {
                $interval['start_page'] = $newInterval['start_page'];
                break;
            } elseif (!$isStartInRange && !$isEndInRange) {
                $intervals[] = ['start_page' => $newInterval['start_page'], 'end_page' => $newInterval['end_page']];
                break;
            }
        }

        return $intervals;
    }

    private function setStartAndEndRanges($oldInterval, $newInterval): array
    {
        $range = ['min_range' => $oldInterval['start_page'], 'max_range' => $oldInterval['end_page']];
        $options = ['options' => $range];

        $isStartInRange = filter_var($newInterval['start_page'], FILTER_VALIDATE_INT, $options);
        $isEndInRange = filter_var($newInterval['end_page'], FILTER_VALIDATE_INT, $options);

        return [$isStartInRange, $isEndInRange];
    }

    private function calculateTotalDifference(array $array): int
    {
        $totalDifference = 0;

        foreach ($array as $item) {
            $totalDifference += $item['end_page'] - $item['start_page'];
        }

        return $totalDifference;
    }
}
