<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TradeRequest;
use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use App\Models\UserExchangeRate;

class TradeController extends Controller
{
    private $user;
    
    public function __construct()
    {
        $this->user = \Auth::user();
    }
    
    /**
     * Store users trade rates
     * @param TradeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TradeRequest $request)
    {
    	//Find user's currency rate
    	$userExchangeRate = $this->user->userExchangeRates()
		    ->where('exchange_rate_id', $request->get('id'))->get()->first();

	    //Create new if not exists
	    if(!$userExchangeRate instanceof  UserExchangeRate){
	    	$userExchangeRate = new UserExchangeRate();
		    $userExchangeRate->user_id = $this->user->id;
		    $userExchangeRate->exchange_rate_id = $request->get('id');
	    }

	    //Populate values
	    foreach( $request->except('id') as $name => $value ) {
	    	$userExchangeRate->{$name} = $value;
	    }

	    //Now just save them
	    $userExchangeRate->save();

        return response()->json(['success' => true, 'rate_id' => $request->get('id')]);
    }

    public function collection(TradeRequest $request)
    {
        $aIds = [];
        $aRequestData = $request->all();
        $data = $this->user->userExchangeRates->keyBy('exchange_rate_id')->toArray();
        foreach ($aRequestData as $row) {
            $aIds[] = $row['id'];
            $data[$row['id']]['type_buy'] = $row['type_buy'];
            $data[$row['id']]['buy'] = $row['buy'];
            $data[$row['id']]['type_sell'] = $row['type_sell'];
            $data[$row['id']]['sell'] = $row['sell'];
        }

        //Save the new rates
        $this->user->exchangeRates()->sync($data);
        return response()->json(['success' => true, 'rate_ids' => $aIds]);
    }
}
