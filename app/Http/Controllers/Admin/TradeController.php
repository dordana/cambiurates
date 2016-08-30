<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TradeRequest;
use App\Http\Requests\UserExchangeRateRequest;
use App\Http\Controllers\Controller;
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
     * Applies users trade rates
     * @param TradeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apply(TradeRequest $request){

        $visible = ($request->get('visible') === 'true') ? 1 : 0;
        $user = \Auth::user();
        $data = $user->userExchangeRates->keyBy('id')->toArray();
        $data[$request->get('id')]['visible'] = $visible;

        $user->exchangeRates()->sync($data);

        return response()->json(['success' => true, 'rate_id' => $request->get('id')]);
    }

    public function collection(TradeRequest $request){

        $aIds = [];
        $user = \Auth::user();
        $data = $user->userExchangeRates->keyBy('id')->toArray();
        foreach ($request->all() as $row) {
            $aIds[] = $row['id'];
            $visible = ($row['visible'] === 'true') ? 1 : 0;
            $data[$row['id']]['visible'] = $visible;
        }
        $user->exchangeRates()->sync($data);

        return response()->json(['success' => true, 'rate_ids' => $aIds]);
    }
}
