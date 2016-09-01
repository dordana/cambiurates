<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TradeRequest;
use App\Http\Requests\UserExchangeRateRequest;
use App\Http\Controllers\Controller;
use App\Models\Markups\MarkupBuy;
use App\Models\Markups\MarkupSell;
use App\Models\UserExchangeRate;
use App\Models\ExchangeRate;

class TradeController extends Controller
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

    /**
     * Store users trade rates
     * @param TradeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TradeRequest $request){

        $user = \Auth::user();
        $data = $user->userExchangeRates->keyBy('exchange_rate_id')->toArray();
        $data[$request->get('id')]['type_buy'] = $request->get('type_buy');
        $data[$request->get('id')]['buy'] = $request->get('buy');
        $data[$request->get('id')]['type_sell'] = $request->get('type_sell');
        $data[$request->get('id')]['sell'] = $request->get('sell');
        $data[$request->get('id')]['visible'] = $request->get('visible');

        //Save the new rates
        $user->exchangeRates()->sync($data);

        return response()->json(['success' => true, 'rate_id' => $request->get('id')]);
    }

    public function collection(TradeRequest $request){

        $aIds = [];
        $user = \Auth::user();
        $aRequestData = $request->all();
        $data = $user->userExchangeRates->keyBy('exchange_rate_id')->toArray();
        foreach ($aRequestData as $row) {
            $aIds[] = $row['id'];
            $data[$row['id']]['type_buy'] = $row['type_buy'];
            $data[$row['id']]['buy'] = $row['buy'];
            $data[$row['id']]['type_sell'] = $row['type_sell'];
            $data[$row['id']]['sell'] = $row['sell'];
            $data[$row['id']]['visible'] = $row['visible'];
        }

        //Save the new rates
        $user->exchangeRates()->sync($data);
        return response()->json(['success' => true, 'rate_ids' => $aIds]);
    }
}
