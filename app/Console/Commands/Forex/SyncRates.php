<?php namespace App\Console\Commands\Forex;

use Illuminate\Console\Command;
use GuzzleHttp;
use App\Models\CityforexRate;

/**
 * Class SyncRates
 * @package Modules\Delivery\Console\Commands\OpenExchangeRates
 */
class SyncRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncrates-forex';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize exchange rates with cityforex';
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(date('Y-m-d H:i:s')." - Start CityForex synchronization");
        // sync all rates
        $this->comment('Fetching rates');
        
        $oClient = new GuzzleHttp\Client();
        $oRes = $oClient->get(
            'https://secure.cityforex.co.uk/order/rsspricefeed.php'
        );
        
        $sBody = $oRes->getBody();
        $oRatesResponse = new \SimpleXMLElement($sBody);
        
        foreach ($oRatesResponse->channel->item as $item) {
            $symbol = substr($item->title, 0, stripos($item->title, ' '));
            
            $oRate = CityforexRate::where(['symbol' => $symbol])->firstOrCreate(['symbol' => $symbol]);
            $oRate->exchange_rate = $item->description;
            $oRate->save();
            $this->comment(date('Y-m-d H:i:s')." - Saving " . $symbol . ' - ' . $item->description);
        }
        
        $this->comment(date('Y-m-d H:i:s')." - Done");
    }
}
