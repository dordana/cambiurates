<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'exchange_rates',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->string('symbol')->unique();
                $table->decimal('exchange_rate', 14, 6);
                $table->timestamps();
            }
        );
    }
    
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exchange_rates');
    }
}
