<?php

use App\Models\Markups\MarkupBuy;
use App\Models\Markups\MarkupSell;
use App\Models\User;
use App\Models\UserExchangeRate;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class UploadExampleUserRatesData
 */
class UploadExampleUserRatesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add some example rates for user with ID 1
        $user = User::find(2);
        $user->exchangeRates()->attach([1 => ['visible' => 1], 2 => ['visible' => 1], 3 => ['visible' => 0]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('user_exchange_rates')->delete();
    }
}
