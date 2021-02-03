<?php

declare(strict_types = 1);

namespace App\Charts;

use DateTime;
use DatePeriod;
use DateInterval;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\BaseChart;
use App\Repositories\Interfaces\BorrowRequestRepositoryInterface;

class DailyBorrowsChart extends BaseChart
{

    public ?array $middlewares = [
        'auth',
    ];

    public function __construct(BorrowRequestRepositoryInterface $borrowRepo)
    {
        $this->borrowRepo = $borrowRepo;
    }

    public function handler(Request $request): Chartisan
    {
        return Chartisan::build()
            ->labels($this->getLabels())
            ->dataset(trans('dashboard.charts.data-description'), $this->getDataSet());
    }

    public function getLabels()
    {
        $period = new DatePeriod(
            new DateTime('00:00'),
            new DateInterval('PT1H'),
            new DateTime('24:00')
        );

        $hours = [];
        foreach ($period as $date) {
            $hours[] = $date->format("H:i");
        }

        return $hours;
    }

    public function getDataSet()
    {
        $borrows = $this->borrowRepo->whereDate(now()->toDateString())
                                    ->pluck('created_at')
                                    ->groupBy(function ($item, $key) {
                                        return $item->hour;
                                    });

        $dataset = [];
        for ($i = 0; $i < 24; $i++) {
            $dataset[] = isset($borrows[$i]) ? $borrows[$i]->count() : 0;
        }

        return $dataset;
    }

}
