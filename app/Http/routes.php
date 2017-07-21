<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'cors'], function() {
    Route::get('/', function () {
        return redirect('/admin');
    });
    
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
    {
        Route::get('/',['as' => 'home', 'uses'    => 'AdminController@index']);
    
        // Authentication Routes...
        Route::get('login', 'Auth\AuthController@showLoginForm');
        Route::post('login', 'Auth\AuthController@authenticate');
        Route::get('logout',['as' => 'logout', 'uses' =>'Auth\AuthController@logout']);
        Route::get('user/edit', ['as' => 'user-edit', 'uses' => 'UserController@edit']);
        Route::post('user/update', ['as' => 'user-update', 'uses' => 'Auth\AuthController@update']);
        
        
        // Password Reset Routes...
        Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
        Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'Auth\PasswordController@reset');
    
        //Every different admin rout need to be authenticate
        Route::group(['middleware' => 'auth'], function()
        {
            Route::group(['middleware' => 'permit'], function()
            {
                // Registration Routes...
                Route::get('users', ['as' => 'users', 'uses' => 'UserController@index']);
                Route::get('user/register',['as' => 'user-register-form', 'uses' => 'Auth\AuthController@showRegistrationForm']);
                Route::post('user/register', ['as' => 'user-register', 'uses' => 'Auth\AuthController@register']);
                Route::get('user/destroy/{id}', ['as' => 'user-destroy', 'uses' => 'UserController@destroy']);
	            Route::post('user/password', ['as' => 'change-password', 'uses' => 'UserController@password']);
            });
    
            //Exchange Rates
            Route::get('exchangerates', 'ExchangeRateController@index')->name('exchangeRates');
    
            //Trade
            Route::post('trade/update', 'TradeController@store');
            Route::post('trade/collection', 'TradeController@collection');
        });
    });
});