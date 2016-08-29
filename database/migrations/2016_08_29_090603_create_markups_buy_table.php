<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkupsBuyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('markups_buy');
    }
}
