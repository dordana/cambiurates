<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExchangeRateRequest;
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
                'aExchangeRates'  => ExchangeRate::searchFor()->has('users', '<', 1)->paginate($this->limit),
                'aUserExchangeRates' => \Auth::user()
                    ->user_exchange_rates()
                    ->with(['exchangeRate','buy','sell'])
                    ->get()
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
        return view('admin.exchangerate.create');
    }

    /**
     * Store in db
     *
     * @param ExchangeRateRequest $oRequest the post request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExchangeRateRequest $oRequest)
    {
        ExchangeRate::create($oRequest->all());
        
        return redirect('admin/exchangerates')->with(['success' => 'Record successfully created!']);
    }

    /**
     * Get edit form
     *
     * @param int $iId the record id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($iId)
    {
        $oExchangeRate = ExchangeRate::find($iId);

        if (!$oExchangeRate) {
            return redirect('admin/exchangerates');
        }
        
        return view(
            'admin.exchangerate.create',
            ['oExchangeRate' => $oExchangeRate]
        );
    }

    /**
     * Update the db record
     *
     * @param ExchangeRateRequest $oRequest the post request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExchangeRateRequest $oRequest)
    {
        $oExchangeRate = ExchangeRate::find($oRequest->get('id'));

        if (!$oExchangeRate) {
            return redirect()->back()->with(['not_found' => 'Sorry, we couldn\'t find that record.']);
        }
        
        $oExchangeRate->update($oRequest->all());
        
        return redirect('admin/exchangerates')->with(
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
        $oExchangeRate = ExchangeRate::find($iId);

        if (!$oExchangeRate) {
            return redirect('admin/exchangerates')->with(['not_found' => 'Sorry, we couldn\'t find that record.']);
        }

        $oExchangeRate->delete();

        return redirect('admin/exchangerates')->with(['success' => 'Record successfully deleted!']);
    }
}
