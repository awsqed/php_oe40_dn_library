<?php

namespace App\Console;

use App\Tasks\BorrowsRemind;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [];

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(app()->make(BorrowsRemind::class))
                    ->weekly()
                    ->fridays()
                    ->at('06:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
