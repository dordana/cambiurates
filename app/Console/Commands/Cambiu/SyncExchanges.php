<?php namespace App\Console\Commands\Cambiu;

use App\Models\Chain;
use App\Models\Country;
use App\Models\Exchange;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class SyncRates
 * @package Modules\Delivery\Console\Commands\XE
 */
class SyncExchanges extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'cambiu:sync-exchanges {country=ALL}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Synchronize countries, chains and exchanges with Cambiu API';

	/**
	 * Execute the console command.
	 * @return mixed
	 * @throws \Exception
	 */
	public function handle()
	{
		//Inform that we started the process
		$this->line(\Carbon\Carbon::now().' Process started!');

		$arg = strtoupper($this->argument('country'));

		//Get countries
		$countries = [];
		if( $arg == 'ALL'){
			$countries = $this->getCountries();
		}else{
			$countries[$arg] = $arg;
		}

		$this->validateResponse($countries);
		$this->info('There are ' . count($countries) . ' countries.');

		//Truncate the old once so to achieve syncing
		DB::table('chains')->delete();

		//First let's get the chains and sync them
		$chains = $this->getChains();
		$this->validateResponse($chains);

		$chains = array_map(function($val){

			//We declare them instead using unset,
			//cause we are not sure whether the api response will change in the future
			return [
				'origin_id' => $val['id'],
				'name' => $val['name']
			];
		}, $chains);

		//Now just insert the new once
		DB::table('chains')->insert($chains);

		//Delete all exchanges first
		DB::table('exchanges')->whereIn('rates_policy', ['individual' , 'chain'] )->delete();

		//Now populate the exchanges for any country
		foreach($countries as $code => $name){


			$country = Country::firstOrCreate([
				'code' => $code
			]);
			$country->name = $name;
			$country->save();


			//Now get all exchanges for this country and sync them
			$exchanges = $this->getExchangesByCountry($code);
			$this->validateResponse($exchanges);

			$exchanges = array_map(function($val){

				//We declare them instead using unset avoiding api changing issues
				return new Exchange([
					'origin_id'       => $val['id'],
					'chain_id'        => $val['chain_id'],
					'name'            => $val['name'],
					'currency'        => $val['currency'],
					'address'         => isset( $val['address'] ) && $val['address'] ? $val['address'] : "",
					'nearest_station' => $val['nearest_station'],
					'phone'           => $val['phone'],
					'rates_policy'    => $val['rates_policy'],
				]);
			}, $exchanges);

			$this->info("Be patient! There are " . count($exchanges) . ' exchanges for '. $name . '.');

			//Now just insert the new once
			$country->exchanges()->saveMany($exchanges);
		}

		$this->info('The countries, chains and exchanges are synced successful.');

		$this->line(\Carbon\Carbon::now() . ' Process stopped.');
	}

	/**
	 * Returns current cambiu API countries
	 * @return array
	 */
	private function getCountries(){

		$process = new Process('node ./app/Console/Commands/Cambiu/Scripts/ApiCountries.js');
		$process->run();

		//Is everything ok with the response?
		if (!$process->isSuccessful()) {
			throw new ProcessFailedException($process);
		}
		return json_decode($process->getOutput(), true);
	}

	/**
	 * Provides all exchange rates per a country from cambiu API
	 * @param $code string The iso code of a country UK, IRK, BG etc.
	 * @return array
	 */
	private function getExchangesByCountry($code){

		//Get exchanges for this country first
		$process = new Process('node ./app/Console/Commands/Cambiu/Scripts/ApiExchanges.js ' . $code);
		$process->run();

		//Is everything ok with the response?
		if (!$process->isSuccessful()) {
			throw new ProcessFailedException($process);
		}

		return json_decode($process->getOutput(), true);
	}

	/**
	 * Provides all exchange rates per a country from cambiu API
	 * @return array
	 */
	private function getChains(){

		//Get exchanges for this country first
		$process = new Process('node ./app/Console/Commands/Cambiu/Scripts/ApiChains.js');
		$process->run();

		//Is everything ok with the response?
		if (!$process->isSuccessful()) {
			throw new ProcessFailedException($process);
		}

		return json_decode($process->getOutput(), true);
	}

	/**
	 * Check for errors in the response or empty response
	 * @param $response
	 *
	 * @throws \Exception
	 */
	public function validateResponse($response){

		if(!$response){

			throw new \Exception("The request returns no data!");
		}

		if(array_key_exists('errors', $response)){
			throw new \Exception(json_encode($response['errors']));
		}
	}
}
