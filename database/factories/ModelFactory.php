<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'role'           => 'user',
        'password'       => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\MarkupBuy::class, function (Faker\Generator $faker) {

    $tradeType = ['fixed', 'percent'];
    $ids = array_column(\App\Models\UserExchangeRate::all('id')->toArray(), 'id');

//    if(!\App\Models\UserExchangeRate::whereNotIn('id', $ids)->get()->count()){
//         throw new \Illuminate\Database\QueryException('There is no more than '. \App\Models\UserExchangeRate::all()->count() .' rows in "urser_exchange_rates" table');
//    }

    return [
        'user_exchange_rate_id' => \App\Models\UserExchangeRate::whereNotIn('id', $ids)->get()->random()->id,
        'trade_type' => $tradeType[rand(0, 1)],
        'value'      => $faker->randomFloat(6,0,100),
        'active'     => rand(0, 1),
    ];
});

$factory->define(App\Models\MarkupSell::class, function (Faker\Generator $faker) {

    $tradeType = ['fixed', 'percent'];
    $ids = array_column(\App\Models\MarkupSell::all('user_exchange_rate_id')->toArray(), 'user_exchange_rate_id');

    if(!\App\Models\UserExchangeRate::whereNotIn('id', $ids)->get()->count()){
        \App\Models\MarkupSell::all()->last()->delete();
        $ids = array_column(\App\Models\MarkupBuy::all('user_exchange_rate_id')->toArray(), 'user_exchange_rate_id');
    }

    return [
        'user_exchange_rate_id' => \App\Models\UserExchangeRate::whereNotIn('id', $ids)->get()->random()->id,
        'trade_type' => $tradeType[rand(0, 1)],
        'value'      => $faker->randomFloat(6,0,100),
        'active'     => rand(0, 1),
    ];
});