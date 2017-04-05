<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExchangeRatesTable201704051618 extends Migration
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
                $table->boolean('is_visible')->default(1)->after('pos');
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
                $table->dropColumn('is_visible');
            }
        );
    }
}
