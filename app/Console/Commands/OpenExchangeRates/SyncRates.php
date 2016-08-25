<?php namespace App\Console\Commands\OpenExchangeRates;

use Illuminate\Console\Command;
use App\Models\ExchangeRate;
use GuzzleHttp;

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
    protected $signature = 'syncrates-oer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize exchange rates with openexchangerates';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(date('Y-m-d H:i:s')." - Start exchange Rate synchronization");
        // sync all rates
        $aRates = ExchangeRate::All();
        $this->comment('Records: '.$aRates->count());
        $sOpenExchangeRatesAPIKey = config('delivery.openExchangeRatesAPIKey');

        if ($sOpenExchangeRatesAPIKey == '') {
            $this->comment('Bailout - no apikey');
            exit;
        }

        $aFetchRates = [];
        foreach ($aRates as $oRate) {
            if ($oRate->symbol == 'GBP') {
                continue;
            }

            $aFetchRates[] = $oRate->symbol;
        }
        $this->comment('Fetching rates for: '.implode(',', $aFetchRates));

        $oClient = new GuzzleHttp\Client();
        $oRes = $oClient->get(
            'https://openexchangerates.org/api/latest.json?app_id='.$sOpenExchangeRatesAPIKey.'&base=GBP&symbols='.implode(
                ',',
                $aFetchRates
            )
        );

        $sBody = $oRes->getBody();
        $oRatesResponse = json_decode($sBody, true);

        $iCount = 0;
        if (is_array($oRatesResponse) && isset($oRatesResponse['rates']) && is_array($oRatesResponse['rates'])) {
            foreach ($oRatesResponse['rates'] as $sSymbol => $fRate) {
                $oRate = ExchangeRate::where(['symbol' => $sSymbol])->first();
                if ($oRate) {
                    $iCount++;
                    $oRate->exchange_rate = $fRate;
                    $oRate->save();
                }
            }
        } else {
            $this->comment(date('Y-m-d H:i:s')." - ERROR SYNCING. BODY: ".$sBody);
        }

        if ($iCount < count($aFetchRates)) {
            $this->comment(date('Y-m-d H:i:s')." - ERROR. Expected: ".count($aFetchRates).' but synced only '.$iCount);
        }

        $this->comment(date('Y-m-d H:i:s')." - Done");
    }
}
