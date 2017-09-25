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
	public function handle(){
		$client = new \GuzzleHttp\Client();

		$res = $client->request('GET', 'https://www.cambiu.com/api/v1/rates?type=reference&base=GBP');
		
		if($res->getStatusCode() == 200){

			$result = json_decode($res->getBody(), true);

			if(isset($result['GBP']) && !empty($result['GBP'])){

				$visibleRates = [];

				foreach ($result['GBP'] as $currency => $rate) {

					if (!is_numeric($rate)) {
						continue;
					}

					$visibleRates[] = $currency;

					ExchangeRate::where(['symbol' => $currency])->update(
						[
							'updated_at' => Carbon::now()->toDateTimeString(),
							'exchange_rate' => $rate
						]
					);
				}

				ExchangeRate::whereIn('symbol', $visibleRates)->update(['is_visible' => 1]);
				ExchangeRate::whereNotIn('symbol', $visibleRates)->update(['is_visible' => 0]);
			}
		}
    }
}
