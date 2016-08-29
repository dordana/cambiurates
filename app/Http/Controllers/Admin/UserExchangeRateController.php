<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserExchangeRateRequest;
use App\Http\Controllers\Controller;
use App\Models\UserExchangeRate;
use App\Models\ExchangeRate;

class UserExchangeRateController extends Controller
{
    
    /**
     * Render ExchangeRates
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view(
            'admin.user_exchangerate.list',
            [
                'userExchangeRates' => UserExchangeRate::where(['user_id' => \Illuminate\Support\Facades\Auth::user()->id])
                    ->paginate($this->limit),
            ]
        );
    }
    
    public function edit(UserExchangeRateRequest $request)
    {
       var_dump($request->all());die;
    }
    
    public function editCollection(UserExchangeRateRequest $request)
    {
      
    }
    
}
