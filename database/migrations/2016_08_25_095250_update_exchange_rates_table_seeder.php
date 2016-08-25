<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ExchangeRate;

class UpdateExchangeRatesTableSeeder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ExchangeRate::create(
            [
                'symbol' => 'USD',
                'title' => 'Dollar',
                'visible' => 1,
                'buy_markup' => 55,
                'sell_markup' => 77,
                'exchange_rate' => 0.72,
            ]
        );
    
        ExchangeRate::create(
            [
                'symbol' => 'EUR',
                'title' => 'Euro',
                'visible' => 1,
                'buy_markup' => 66,
                'sell_markup' => 88,
                'exchange_rate' => 0.78,
            ]
        );
    
        ExchangeRate::create(
            [
                'symbol' => 'CND',
                'title' => 'Canadian Dollar',
                'visible' => 1,
                'buy_markup' => 33,
                'sell_markup' => 44,
                'exchange_rate' => 0.53,
            ]
        );
    
        ExchangeRate::create(
            [
                'symbol' => 'AUD',
                'title' => 'Australian Dollar',
                'visible' => 1,
                'buy_markup' => 22,
                'sell_markup' => 33,
                'exchange_rate' => 0.52,
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
