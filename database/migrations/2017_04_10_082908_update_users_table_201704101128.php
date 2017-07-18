<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable201704101128 extends Migration
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
                $table->string('rates_policy')->nullable()->after('nearest_station');
                $table->string('chain')->default(null)->nullable()->after('rates_policy');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rates_policy');
            $table->dropColumn('chain');
        });
    }
}
