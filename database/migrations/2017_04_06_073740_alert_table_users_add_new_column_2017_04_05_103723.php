<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableUsersAddNewColumn20170405103723 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(
		    'users',
		    function (Blueprint $table) {
			    $table->string('nearest_station')->default(null)->nullable()->after('name');
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
	    Schema::table( 'users', function (Blueprint $table) {
			    $table->dropColumn('nearest_station');
		    }
	    );
    }
}
