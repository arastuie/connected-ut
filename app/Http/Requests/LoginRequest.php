<?php namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (! Auth::check());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|regex:/.+@rockets.utoledo.edu/',
            'password' => 'required'
        ];
    }

    /**
     * Custom error messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'regex' => 'You must use your @rockets.utoledo.edu email address to login.'
        ];
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