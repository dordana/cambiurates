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
        
        return view(
            'admin.exchangerate.list',
            [
                'oUserOnlyRates' => ExchangeRate::searchFor()->userOnly()->get(),
                'oNoUserRates'   => ExchangeRate::searchFor()->exceptUser()->get(),
                'title'          => 'Exchange Rates',
                'aCurrencies'    => ExchangeRate::exceptUser()->get()
            ]
        );
    }
}
