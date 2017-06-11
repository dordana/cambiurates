<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TradeRequest;
use App\Http\Controllers\Controller;

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

    	//Update user's currency rate
    	$this->user->userExchangeRates()
		    ->where('exchange_rate_id', $request->get('id'))
            ->delete();

        $data = $request->except('id');
        $data['exchange_rate_id'] = $request->get('id');
        $data['user_id'] = $this->user->id;

        $this->user->userExchangeRates()
		    ->insert($data);

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
