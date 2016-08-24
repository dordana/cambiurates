<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class UploadUsersSampleData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create our example user
        User::create([
            'name'     => 'John Doe',
            'role'     => 'admin',
            'email'    => 'john.doe@example.net',
            'password' => bcrypt('password'),
        ]);

        // Create 9 more
        factory(\App\Models\User::class, 9)->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->truncate();
    }
}
