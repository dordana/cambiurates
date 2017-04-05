<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\XE\SyncRates as SyncRatesXE;
use App\Console\Commands\OpenExchangeRates\SyncRates as SyncRatesOER;
use App\Console\Commands\Cambiu\SyncRates as SyncRatesCambiu;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        SyncRatesXE::class,
        SyncRatesOER::class,
        SyncRatesCambiu::class
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
            $schedule->command('syncrates-cambiu')
                ->withoutOverlapping()
                ->hourly()
                ->appendOutputTo(storage_path('logs/command.log'));
        }
    }
}
