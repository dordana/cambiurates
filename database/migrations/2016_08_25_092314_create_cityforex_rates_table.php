<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\CityforexRate;

class CreateCityforexRatesTable extends Migration
{
    public function up()
    {
        Schema::create('cityforex_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('symbol')->unique();
            $table->decimal('exchange_rate', 14, 6);
            $table->timestamps();
        });
        
        $rates = [
            ['symbol' => 'USD', 'exchange_rate' => 0],
            ['symbol' => 'EUR', 'exchange_rate' => 0],
        ];
        foreach ($rates as $rate) {
            CityforexRate::create($rate);
        }
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cityforex_rates');
    }
}
