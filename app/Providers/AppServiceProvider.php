<?php

namespace App\Providers;

use App\Models\ExchangeRate;
use App\Models\Order\Delivery;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if(!\Schema::hasTable('exchange_rates')){
            return;
        }

        $currencies = ExchangeRate::all();
        $data = [];
        foreach($currencies as $currency) {
            $data[$currency->symbol] = $currency->sellRate;
        }
        
        view()->share('localJsVars', [
            'now' => 'new Date(' .time() * 1000 . ')',
            'deliveryCost' => config('delivery.deliveryCost'),
            'deliveryCostSaturday' => config('delivery.deliveryCostSaturday'),
            'deliveryCashLimit' => config('delivery.cashLimit'),
            'deliveryMinOrder' => config('delivery.minOrder'),
            'collectionCashLimit' => config('collection.cashLimit'),
            'collectionMinOrder' => config('collection.minOrder'),
            'bankHolidays' => '[]',
            'currentHour' => date('G'),
            'currentMinutes' => date('i'),
            'euroCardMin' => config('card.euroMin'),
            'euroCardLimit' => config('card.euroMax'),
            'dollarCardMin' => config('card.dollarMin'),
            'dollarCardLimit' => config('card.dollarMax'),
            'globalCardMin' => config('card.globalMin'),
            'globalCardLimit' => config('card.globalMax'),
            'nextDayEnabled' => 'false',
            'deliveryCutoffTimeOther' => '0',
            'deliveryCutoffTimeEurUsd' => '0',
            'setFullYear_y' => date('Y'),
            'setFullYear_m' => (date('m') - 1),
            'setFullYear_d' => date('d'),
            'setHours' => date('H'),
            'setMinutes' => date('i'),
            'min_date' => 'new Date()',
            'currencies' => json_encode($data),
        ]);
        
        view()->share('cards', [
            'euro' => 'Euro',
            'dollar' => 'United States Dollar',
            'global' => 'Global Card'
        ]);
        
        view()->share('euro', ExchangeRate::where('symbol', '=', 'EUR')->first());
        view()->share('dollar', ExchangeRate::where('symbol', '=', 'USD')->first());
        view()->share('global', ExchangeRate::where('symbol', '=', 'GBP')->first());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
