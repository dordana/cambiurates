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

            $rules = [
                '*.id' => 'required|numeric',
                '*.type_sell' => 'required|in:fixed,percent,disabled',
                '*.type_buy' => 'required|in:fixed,percent,disabled',
                '*.sell' => 'required|numeric',
                '*.buy' => 'required|numeric'
            ];

            return $rules;
        }

        $rules = [
            'id' => 'required|numeric',
            'type_sell' => 'required|in:fixed,percent,disabled',
            'type_buy' => 'required|in:fixed,percent,disabled',
            'sell' => 'required|numeric',
            'buy' => 'required|numeric'
        ];

        return $rules;
    }
}
