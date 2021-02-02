<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\BaseChart;
use App\Repositories\Interfaces\BorrowRequestRepositoryInterface;

class MonthlyBorrowsChart extends BaseChart
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
        $days = [];
        for ($i = 1; $i <= now()->daysInMonth; $i++) {
            $days[] = $i;
        }

        return $days;
    }

    public function getDataSet()
    {
        $borrows = $this->borrowRepo->whereMonth(now()->month)
                                    ->pluck('created_at')
                                    ->groupBy(function ($item, $key) {
                                        return $item->day;
                                    });

        $dataset = [];
        for ($i = 1; $i <= now()->daysInMonth; $i++) {
            $dataset[] = isset($borrows[$i]) ? $borrows[$i]->count() : 0;
        }

        return $dataset;
    }

}
