<?php namespace App\Console\Commands\XE;

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
    protected $signature = 'syncrates-xe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize exchange rates with XE.com';

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
        $sXeAccId = config('delivery.xecomAccountId');
        $sXeAPIKey = config('delivery.xecomAPIKey');

        if ($sXeAccId == '' || $sXeAPIKey == '') {
            $this->comment('Bailout - no accid or apikey');
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
            'https://xecdapi.xe.com/v1/convert_from.json/?from=GBP&to='.implode(',', $aFetchRates).'&amount=1',
            ['auth' => [$sXeAccId, $sXeAPIKey]]
        );

        $sBody = $oRes->getBody();
        $oRatesResponse = json_decode($sBody);

        if (is_object($oRatesResponse) && isset($oRatesResponse->to) && is_array($oRatesResponse->to)) {
            foreach ($oRatesResponse->to as $oRateResponse) {
                $oRate = ExchangeRate::where(['symbol' => $oRateResponse->quotecurrency])->first();
                if ($oRate) {
                    $oRate->exchange_rate = $oRateResponse->mid;
                    $oRate->save();
                }
            }
        }

        $this->comment(date('Y-m-d H:i:s')." - Done");
    }
}
