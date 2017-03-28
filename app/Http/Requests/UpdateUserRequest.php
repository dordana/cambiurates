<?php

namespace App\Http\Requests;


class UpdateUserRequest extends Request
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
            'name'  => 'required|max:255',
            'email' => 'required|unique:' . app('App\Models\User')->getTable() . ',email,' . $this->input('id') . '|max:255'
        ];
        
        if (trim($this->input('password')) != '') {
            $rules['password'] = 'required|confirmed|min:6';
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
        return [];
    }
}
