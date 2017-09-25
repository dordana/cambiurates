<?php

namespace App\Console;

use App\Console\Commands\Cambiu\SyncExchanges;
use App\Console\Commands\Cambiu\SyncRates;
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
        SyncExchanges::class,
	    SyncRates::class
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
	        $schedule->command('cambiu:sync-exchanges')
	                 ->withoutOverlapping()
	                 ->daily()
	                 ->appendOutputTo(storage_path('logs/command.log'));

            $schedule->command('cambiu:sync-rates')
                ->withoutOverlapping()
                ->hourly()
                ->appendOutputTo(storage_path('logs/command.log'));
        }

        if (config('app.env') == 'dev') {
	        $schedule->command('cambiu:sync-exchanges')
	                 ->withoutOverlapping()
	                 ->everyMinute()
	                 ->appendOutputTo(storage_path('logs/command.log'));

            $schedule->command('cambiu:sync-rates')
                ->withoutOverlapping()
                ->everyMinute()
                ->appendOutputTo(storage_path('logs/command.log'));
        }
    }
}
