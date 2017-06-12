<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('origin_id')->unsigned()->unique();
	        $table->integer('country_id')->unsigned();
	        $table->integer('chain_id')->unsigned()->nullable();
	        $table->string('name');
	        $table->string('currency');
	        $table->string('address');
	        $table->string('nearest_station');
	        $table->string('phone');
	        $table->string('rates_policy');
            $table->timestamps();

	        $table->foreign('country_id')
	              ->references('id')->on('countries')
	              ->onDelete('cascade');

	        $table->foreign('chain_id')
	              ->references('origin_id')->on('chains')
	              ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exchanges');
    }
}
