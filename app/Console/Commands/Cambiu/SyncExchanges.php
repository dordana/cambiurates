<?php namespace App\Console\Commands\Cambiu;

use App\Models\Chain;
use App\Models\Country;
use App\Models\Exchange;
use Illuminate\Console\Command;
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
	protected $signature = 'cambiu:sync-exchanges';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Synchronize countries, chains and exchanges with Cambiu API';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		//Inform that we started the process
		$this->line(\Carbon\Carbon::now().' Process started!');

		//Get countries
		$countries = $this->getCountries();
		$this->info('There are ' . count($countries) . ' countries.');

		//Truncate the old once so to achieve syncing
		\DB::table('chains')->delete();
		\DB::table('exchanges')->delete();

		foreach($countries as $code => $name){

			$country = Country::firstOrCreate([
				'code' => $code,
				'name' => $name
			]);


			//First let's get the chains
			$chains = $this->getChainsByCountry($code);
			$chains = array_map(function($val){

				//We declare them instead using unset,
				//cause we are not sure whether the api response will change in the future
				return new Chain([
					'origin_id' => $val['id'],
					'name' => $val['name']
				]);
			}, $chains);


			//Now just insert the new once
			$country->chains()->saveMany($chains);

			//Now get all exchanges for this country and sync them
			$exchanges = $this->getExchangesByCountry($code);
			$exchanges = array_map(function($val){

				//We declare them instead using unset avoiding api changing issues
				return new Exchange([
					'origin_id' => $val['id'],
					'name' => $val['name'],
					'currency' => $val['currency'],
					'address' => $val['address'],
					'nearest_station' => $val['nearest_station'],
					'phone' => $val['phone'],
					'rates_policy' => $val['rates_policy'],
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

		$process = new Process('node ./app/Console/Commands/Cambiu/scripts/ApiCountries.js');
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
		$process = new Process('node ./app/Console/Commands/Cambiu/scripts/ApiExchanges.js ' . $code);
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
	private function getChainsByCountry($code){

		//Get exchanges for this country first
		$process = new Process('node ./app/Console/Commands/Cambiu/scripts/ApiChains.js ' . $code);
		$process->run();

		//Is everything ok with the response?
		if (!$process->isSuccessful()) {
			throw new ProcessFailedException($process);
		}

		return json_decode($process->getOutput(), true);
	}
}
