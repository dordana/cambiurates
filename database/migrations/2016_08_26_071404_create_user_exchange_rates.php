<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExchangeRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'user_exchange_rates',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('exchange_rate_id');
                $table->enum('markup_type',['fixed','percent']);
                $table->decimal('buy_markup_fixed', 14, 6);
                $table->decimal('sell_markup_fixed', 14, 6);
                $table->decimal('buy_markup_percent', 6, 2);
                $table->decimal('sell_markup_percent', 6, 2);
                $table->boolean('visible');
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
        //
    }
}
