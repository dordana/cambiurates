<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'exchange_rates',
            function (Blueprint $table) {
                $table->integer('pos')->after('exchange_rate');
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
        Schema::table(
            'exchange_rates',
            function (Blueprint $table) {
                $table->dropColumn('pos');
            }
        );
    }
}
