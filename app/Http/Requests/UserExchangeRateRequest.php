<?php

namespace App\Http\Requests;

class UserExchangeRateRequest extends Request
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
        $rules = [
            'id' => 'required',
            'trade_type'   => 'required',
            'buy_margin' => 'numeric',
            'rate_buy'  => 'numeric',
            'rate_sell' => 'numeric'
        ];
        return $rules;
    }
    
    /**
     * Get error messages
     *
     * @return array
     */
    public function messages()
    {
        return[];
    }
}
