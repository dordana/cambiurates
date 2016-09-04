<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       \App\Models\User::where(['email' => 'john.doe@example.net'])->update(['role' => 'admin']);
    
        Schema::table('users', function(Blueprint $table)
        {
            $table->string('cambiu_id')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('cambiu_id');
        });
    }
}
