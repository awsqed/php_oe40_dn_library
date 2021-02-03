<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\BaseChart;
use App\Repositories\Interfaces\BorrowRequestRepositoryInterface;

class YearlyBorrowsChart extends BaseChart
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
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = now()->month($i)->shortMonthName;
        }

        return $months;
    }

    public function getDataSet()
    {
        $borrows = $this->borrowRepo->whereYear(now()->year)
                                    ->pluck('created_at')
                                    ->groupBy(function ($item, $key) {
                                        return $item->month;
                                    });

        $dataset = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataset[] = isset($borrows[$i]) ? $borrows[$i]->count() : 0;
        }

        return $dataset;
    }

}
