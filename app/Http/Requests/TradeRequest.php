<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TradeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if(substr(parent::route()->getUri(), -10) === 'collection'){

            return $rules;

            foreach (parent::all() as $key => $rate) {
                $rules[$key]['id'] = 'required';
                $rules[$key]['visible'] = 'in:true,false';

                if(parent::get('sell_trade_type') !== 'disabled'){
                    $rules[$key]['sell'] = 'required';
                }

                if(parent::get('buy_trade_type') !== 'disabled'){
                    $rules[$key]['buy'] = 'required';
                }
            }

            return $rules;
        }

        $rules['id'] = 'required|numeric';
        $rules['visible'] = 'required|in:true,false';
        $rules['sell_trade_type'] = 'required_if:sell_trade_type,!==,disabled';
        $rules['buy_trade_type'] = 'required_if:buy_trade_type,!==,disabled';

        return $rules;
    }
}
