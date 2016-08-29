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
    
    /**
     * Create an exchangeRate
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user_exchangerate.create',
            [
                'rates' => ExchangeRate::forThisUser()
            ]
        );
    }
    
    /**
     * Store in db
     *
     * @param UserExchangeRateRequest $oRequest the post request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserExchangeRateRequest $oRequest)
    {
        $data = [];
        $data['exchange_rate_id'] = '';
        $data['user_id'] = \Illuminate\Support\Facades\Auth::user()->id;
        $data['markup_type'] = $oRequest->input('markup_type');
        
        if($data['markup_type'] == 'percent') {
            $data['sell_markup_percent'] = $oRequest->input('sell_markup');
            $data['buy_markup_percent'] = $oRequest->input('buy_markup');
        } else {
            $data['sell_markup_fixed'] = $oRequest->input('sell_markup');
            $data['buy_markup_fixed'] = $oRequest->input('buy_markup');
        }
        if($oRequest->input('visible') != '') {
            $data['visible'] = 1;
        }
       
        foreach ($oRequest->input('exchange_rate_id') as $rate_id) {
            $data['exchange_rate_id'] = $rate_id;
            UserExchangeRate::create($data);
        }
        
        return redirect('admin/my-exchange-rates')->with(['success' => 'Record successfully created!']);
    }
    
  
    public function edit(UserExchangeRateRequest $request)
    {
       var_dump($request->all());
    }
    
    public function editCollection(UserExchangeRateRequest $request)
    {
        pr($request->all());
    }
    
    /**
     * Update the db record
     *
     * @param UserExchangeRateRequest $oRequest the post request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserExchangeRateRequest $oRequest)
    {
        die('he');
        $oExchangeRate = UserExchangeRate::find($oRequest->get('id'));
        
        if (!$oExchangeRate) {
            return redirect()->back()->with(['not_found' => 'Sorry, we couldn\'t find that record.']);
        }
        
        $oExchangeRate->update($oRequest->all());
        
        return redirect('admin/my-exchange-rates')->with(
            ['success' => 'Record successfully updated!']
        );
    }
    
    /**
     * Delete the record
     *
     * @param int $iId the record id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($iId)
    {
        $oExchangeRate = UserExchangeRate::find($iId);
        
        if (!$oExchangeRate) {
            return redirect('admin/my-exchange-rates')->with(['not_found' => 'Sorry, we couldn\'t find that record.']);
        }
        
        $oExchangeRate->delete();
        
        return redirect('admin/my-exchange-rates')->with(['success' => 'Record successfully deleted!']);
    }
    
    
}
