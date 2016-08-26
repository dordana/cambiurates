<?php

namespace App\Http\Requests;

class ExchangeRateRequest extends Request
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
            'symbol' => 'required|size:3|unique:'.app('App\Models\ExchangeRate')->getTable().',symbol'.($this->input('id') != null ? ','.$this->input('id') : ''),
            'title' => 'required',
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
