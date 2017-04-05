<?php namespace App\Console\Commands\Cambiu;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
    
    
        $process = new Process('node ./app/Console/Commands/Cambiu/SyncRates.js');
        $process->run();
    
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    
        echo $process->getOutput();
        
    }
}
