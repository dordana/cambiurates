<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{

    /**
     * Render ExchangeRates
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

//    	var_dump(ExchangeRate::all());die;
        return view(
            'admin.exchangerate.list',
            [
                'aExchangeRates'  => ExchangeRate::searchFor()
                    ->byUser()
//	                ->supportedOnly()
                    ->orderBy('visible','DESC')
                    ->orderBy('symbol','ASC')
	                ->get(),
	            'title' => 'Exchange Rates',
	            'aCurrencies' => ExchangeRate::all()
            ]
        );
    }
}
