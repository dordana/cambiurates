<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\XE\SyncRates as SyncRatesXE;
use App\Console\Commands\OpenExchangeRates\SyncRates as SyncRatesOER;
use App\Console\Commands\Forex\SyncRates as SyncRatesForex;

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
        SyncRatesForex::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//       $schedule->command('syncrates-oer')
//            ->withoutOverlapping()
//            ->everyTenMinutes()
//            ->appendOutputTo(storage_path('logs/command.log'));
//        $schedule->command('syncrates')
//            ->withoutOverlapping()
//            ->cron('0 */2 * * *')
//            ->weekdays()
//            ->appendOutputTo(storage_path('logs/command.log'));
       
        if (config('app.env') == 'production') {
            $schedule->command('syncrates-xe')
                ->withoutOverlapping()
                ->cron('0 * * * 1-5')
                ->appendOutputTo(storage_path('logs/command.log'));
    
            $schedule->command('syncrates-forex')
                ->withoutOverlapping()
                ->cron('0 * * * 1-5')
                ->appendOutputTo(storage_path('logs/command.log'));
        }
    }
}
