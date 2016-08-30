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
        $user = User::find(1);
        $user->exchangeRates()->attach([1 => ['visible' => 1], 2 => ['visible' => 1], 3 => ['visible' => 0]]);

        $tradeType = ['fixed', 'percent'];
        $faker = Faker\Factory::create();
        foreach (UserExchangeRate::all() as $userExchangeRate) {
            MarkupBuy::create([
                'user_exchange_rate_id' => $userExchangeRate->id,
                'trade_type'            => $tradeType[rand(0, 1)],
                'value'                 => $faker->randomFloat(6, $userExchangeRate->exchangeRate->exchangeRate, ($userExchangeRate->exchangeRate->exchangeRate + 5)),
                'active'                => rand(0, 1)
            ]);
            MarkupSell::create([
                'user_exchange_rate_id' => $userExchangeRate->id,
                'trade_type'            => $tradeType[rand(0, 1)],
                'value'                 => $faker->randomFloat(6, $userExchangeRate->exchangeRate->exchangeRate, ($userExchangeRate->exchangeRate->exchangeRate + 5)),
                'active'                => rand(0, 1)
            ]);
        }

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
