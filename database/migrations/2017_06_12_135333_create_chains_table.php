<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chains', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('origin_id')->unsigned();
	        $table->integer('country_id')->unsigned()->nullable();
	        $table->string('name');
            $table->timestamps();

	        $table->unique(['origin_id', 'country_id']);

	        $table->foreign('country_id')
	              ->references('id')->on('countries')
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
        Schema::drop('chains');
    }
}
