<?php

namespace App\Http\Requests;


class AuthRequest extends Request
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:'.app('App\Models\User')->getTable().',email,|max:255',
            'password' => 'required|confirmed|min:6',
            'cambiu_id' => 'required'
        ];

        if ($this->input('id') != null) {
            $rules['email'] = 'required|unique:'.app('App\Models\User')->getTable().',email,' . $this->input('id').'|max:255';
        }

        return $rules;
    }
    
    /**
     * Get error messages
     *
     * @return array
     */
    public function messages()
    {
        $aMessages = [
            'cambiu_id.required' => 'The Cambiu Id field is required.',
        ];
        
        return $aMessages;
    }
}
