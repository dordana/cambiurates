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
            'name' => 'required|unique:'.app('App\Models\User')->getTable().',name,|max:255',
            'email' => 'required|email|unique:'.app('App\Models\User')->getTable().',email,|max:255',
            'cambiu_id' => 'required|max:255'
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
        $aMessages = [
            'cambiu_id.required' => 'The Exchange or Chain field is required.',
            'name.unique' => 'This Exchange or Chain has already been taken.'
        ];
        
        return $aMessages;
    }
}
