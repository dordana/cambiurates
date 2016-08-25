<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityforexUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cityforex_user_data', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('email');
            $table->string('phone');
            $table->enum('type', ['doddle', 'office', 'airport']);
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cityforex_user_data');
    }
}
