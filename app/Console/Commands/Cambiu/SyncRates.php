<?php namespace App\Console\Commands\Cambiu;

use Illuminate\Console\Command;
use App\Models\ExchangeRate;
use GuzzleHttp;

/**
 * Class SyncRates
 * @package Modules\Delivery\Console\Commands\XE
 */
class SyncRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncrates-cambiu';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize exchange rates with Cambiu API';
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(date('Y-m-d H:i:s')." - Start exchange Rate synchronization");
        
        //
        
        $this->comment(date('Y-m-d H:i:s')." - Done");
    }
}
