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
     * Applies users trade rates
     * @param TradeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apply(TradeRequest $request){

        $user = \Auth::user();
        $data = $user->userExchangeRates->keyBy('exchange_rate_id')->toArray();
        $data[$request->get('id')]['visible'] = $request->get('visible');

        //Save the new rates
        $user->exchangeRates()->sync($data);

        //Save the markups
        $sBuyType = $request->get('buy_trade_type');
        $iBuyActive = $iSellActive = 0;
        if($sBuyType === 'disabled'){
            $sBuyType = '';
            $iBuyActive = 1;
        }

        $sSellType = $request->get('sell_trade_type');
        if($sSellType === 'disabled'){

            $sSellType = '';
            $iSellActive = 1;
        }
        $oBuyMarkup = new MarkupBuy(['trade_type' => $sBuyType, 'value' => $request->get('buy'), 'active' => $iBuyActive]);
        $oSellMarkup = new MarkupSell(['trade_type' => $sSellType, 'value' => $request->get('sell'), 'active' => $iSellActive]);
        $oUserExchangeRate = UserExchangeRate::where('user_id', $user->id)->where('exchange_rate_id', $request->get('id'))->first();
        $oUserExchangeRate->buy()->save($oBuyMarkup);
        $oUserExchangeRate->sell()->save($oSellMarkup);

        return response()->json(['success' => true, 'rate_id' => $request->get('id')]);
    }

    public function collection(TradeRequest $request){

        $aIds = [];
        $user = \Auth::user();
        $aRequestData = $request->all();
        $data = $user->userExchangeRates->keyBy('exchange_rate_id')->toArray();
        foreach ($aRequestData as $row) {
            $aIds[] = $row['id'];
            $data[$row['id']]['visible'] = $row['visible'];
        }

        //Save the new rates
        $result = $user->exchangeRates()->sync($data);

        //Save the markups
        foreach ($result['attached'] as $iExchangeRateId) {

            $sBuyType = $aRequestData[$iExchangeRateId]['buy_trade_type'];
            $iBuyActive = $iSellActive = 0;
            if($sBuyType === 'disabled'){
                $sBuyType = '';
                $iBuyActive = 1;
            }

            $sSellType = $aRequestData[$iExchangeRateId]['sell_trade_type'];
            if($sSellType === 'disabled'){

                $sSellType = '';
                $iSellActive = 1;
            }
            $oBuyMarkup = new MarkupBuy(['trade_type' => $sBuyType, 'value' => $aRequestData[$iExchangeRateId]['buy'], 'active' => $iBuyActive]);
            $oSellMarkup = new MarkupSell(['trade_type' => $sSellType, 'value' => $aRequestData[$iExchangeRateId]['sell'], 'active' => $iSellActive]);
            $oUserExchangeRate = UserExchangeRate::where('user_id', $user->id)->where('exchange_rate_id', $aRequestData[$iExchangeRateId]['id'])->first();
            $oUserExchangeRate->buy()->save($oBuyMarkup);
            $oUserExchangeRate->sell()->save($oSellMarkup);
        }

        return response()->json(['success' => true, 'rate_ids' => $aIds]);
    }
}
