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
        }

        $rules['id'] = 'required|numeric';
        $rules['visible'] = 'required|in:1,0';
        $rules['type_sell'] = 'required|in:fixed,percent,disabled';
        $rules['type_buy'] = 'required|in:fixed,percent,disabled';
        $rules['sell'] = 'required|numeric';
        $rules['buy'] = 'required|numeric';

        return $rules;
    }
}
