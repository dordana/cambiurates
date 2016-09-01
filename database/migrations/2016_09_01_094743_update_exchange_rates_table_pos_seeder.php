<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ExchangeRate;

class UpdateExchangeRatesTablePosSeeder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pos = 0;
        $rates  = ExchangeRate::orderBy('symbol', 'asc')->get();
        foreach ($rates as $rate) {
            $rate->pos = $pos;
            $rate->save();
            $pos++;
        }
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
