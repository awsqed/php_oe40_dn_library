<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BorrowRequestRepositoryInterface;

class DashboardController extends Controller
{

    public function __construct(BorrowRequestRepositoryInterface $borrowRepo)
    {
        $this->borrowRepo = $borrowRepo;
    }

    public function index()
    {
        $now = now();

        $date = date('d-m-Y');
        $month = $now->monthName;
        $year = date('Y');

        $todayCount = $this->borrowRepo->whereDate($now->toDateString())->count();
        $monthlyCount = $this->borrowRepo->whereMonth($now->month)->count();
        $yearlyCount = $this->borrowRepo->whereYear($year)->count();

        return view('dashboard.index', compact('todayCount', 'monthlyCount', 'yearlyCount', 'date', 'month', 'year'));
    }

}
