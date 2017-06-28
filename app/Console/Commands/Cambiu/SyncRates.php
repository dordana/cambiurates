<?php namespace App\Console\Commands\Cambiu;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\DB;

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
	protected $signature = 'cambiu:sync-rates';

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


		$process = new Process('node ./app/Console/Commands/Cambiu/Scripts/SyncRates.js');
		$process->run();

		// executes after the command finishes
		if (!$process->isSuccessful()) {
			throw new ProcessFailedException($process);
		}

		$result = json_decode($process->getOutput());
        
        $visibleRates = [];
    
        if (isset($result[0]->rates)) {
            foreach (current($result)->rates as $rate) {
                
                if (!is_numeric($rate->buy)) {
                    continue;
                }
                
                $visibleRates[] = $rate->currency;
                
                ExchangeRate::where(['symbol' => $rate->currency])->update(
                    [
                        'updated_at'    => Carbon::parse($rate->updated_at)->format('Y-m-d H:i:s'),
                        'exchange_rate' => $rate->buy
                    ]
                );
            }
            
            ExchangeRate::whereIn('symbol', $visibleRates)->update(['is_visible' => 1]);
            ExchangeRate::whereNotIn('symbol', $visibleRates)->update(['is_visible' => 0]);
        }
    }
}
