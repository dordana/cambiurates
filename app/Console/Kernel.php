<?php

namespace App\Console;

use App\Console\Commands\Cambiu\ApiSync;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ApiSync::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        if (config('app.env') == 'production') {
            $schedule->command('cambiu-apisync')
                ->withoutOverlapping()
                ->hourly()
                ->appendOutputTo(storage_path('logs/command.log'));
        }
    }
}
