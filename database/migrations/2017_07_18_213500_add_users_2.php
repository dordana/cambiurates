<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class AddUsers2 extends Migration
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
            'name'     => 'Dror Poliak,
            'role'     => 'admin',
            'email'    => 'dror@cambiu.com',
            'password' => bcrypt('password'),
        ]);
 
        User::create([
            'name'     => 'Eyal Daskal,
            'role'     => 'admin',
            'email'    => 'eyal@cambiu.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name'     => 'Yonatan Brand,
            'role'     => 'admin',
            'email'    => 'yonatan@cambiu.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name'     => 'Anat Alroy,
            'role'     => 'admin',
            'email'    => 'anat@cambiu.com',
            'password' => bcrypt('password'),
        ]);
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
