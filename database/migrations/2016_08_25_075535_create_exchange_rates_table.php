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
                $table->boolean('visible');
                $table->decimal('buy_markup', 6, 2);
                $table->decimal('sell_markup', 6, 2);
                $table->decimal('exchange_rate', 14, 6);
                $table->decimal('ttt_sell', 14, 6);
                $table->integer('featured');
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
