<?php namespace App\Console\Commands\Cambiu;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class SyncRates
 * @package Modules\Delivery\Console\Commands\XE
 */
class ApiSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cambiu-apisync';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize countries, chains, exchanges and exchange rates with Cambiu API';
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    
    
        $process = new Process('node ./app/Console/Commands/Cambiu/ApiSync.js');
        $process->run();
    
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    
        echo $process->getOutput();
        
    }
}
