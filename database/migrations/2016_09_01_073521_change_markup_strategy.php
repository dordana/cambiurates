<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMarkupStrategy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('markups_buy');
        Schema::drop('markups_sell');

        Schema::table('user_exchange_rates', function(Blueprint $table)
        {
            $table->enum('type_buy', ['fixed', 'percent', 'disabled'])->after('exchange_rate_id');
            $table->decimal('buy', 14, 6)->after('type_buy');
            $table->enum('type_sell', ['fixed', 'percent', 'disabled'])->after('type_buy');
            $table->decimal('sell', 14, 6)->after('type_sell');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::create('markups_sell', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_exchange_rate_id')->unsigned();
            $table->enum('trade_type', ['fixed', 'percent']);
            $table->decimal('value', 14, 6);
            $table->boolean('active')->default(0);
            $table->timestamps();

            $table->unique(['user_exchange_rate_id']);

            $table->foreign('user_exchange_rate_id')
                ->references('id')->on('user_exchange_rates')
                ->onDelete('cascade');
        });
        Schema::create('markups_buy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_exchange_rate_id')->unsigned();;
            $table->enum('trade_type', ['fixed', 'percent']);
            $table->decimal('value', 14, 6);
            $table->boolean('active')->default(0);
            $table->timestamps();

            $table->unique(['user_exchange_rate_id']);

            $table->foreign('user_exchange_rate_id')
                ->references('id')->on('user_exchange_rates')
                ->onDelete('cascade');
        });
        Schema::table('user_exchange_rates', function(Blueprint $table)
        {
            $table->dropColumn('type_buy');
            $table->dropColumn('buy');
            $table->dropColumn('type_sell');
            $table->dropColumn('sell');
        });
    }
}
