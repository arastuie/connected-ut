<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
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
        return [
            'email' => 'required|email|max:255|unique:users|regex:/.+@rockets.utoledo.edu/',
            'password' => 'required|min:6|confirmed'
        ];
    }

    /**
     * Custom error messages
     *
     * @return array
     */
    public function messages()
    {
        $messages['regex'] = 'You must use your @rockets.utoledo.edu email address to sign up.';
        $messages['min'] = 'Your password must have at least 6 characters';
        return $messages;
    }


    /**
     * Email address to lower case before validation
     *
     * @return array
     */
    public function all()
    {
        $inputs = parent::all();

        $inputs['email']  = strtolower($inputs['email']);

        return $inputs;
    }
}
