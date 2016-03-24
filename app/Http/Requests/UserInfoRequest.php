<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserInfoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::check());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if(array_key_exists('firstname', $this->all()))
            $rules['firstname'] = 'required|min:2|max:99';

        if(array_key_exists('lastname', $this->all()))
            $rules['lastname'] = 'required|min:2|max:99';

        if(array_key_exists('contact_email', $this->all()))
            $rules['contact_email'] = 'required|email|max:255';

        if($this->has('phone_number'))
            $rules['phone_number'] = 'regex:/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/';

        if($this->has('use_phone'))
            $rules['use_phone'] = 'boolean';

        if($this->has('use_email'))
            $rules['use_email'] = 'boolean';

        return $rules;
    }


    /**
     * Pre-validation changes
     *
     * @return array
     */
    public function all()
    {
        $inputs = parent::all();

        // toLower email and sets use_email to false if not set
        if(array_key_exists('contact_email', $inputs)){
            $inputs['contact_email']  = strtolower($inputs['contact_email']);
            if(! array_key_exists('use_email', $inputs))
                $inputs['use_email'] = 0;
        }

        // Sets use_phone to false if phone_number is empty or
        // phone number is not empty but use_phone is.
        if(array_key_exists('phone_number', $inputs) &&
            (! array_key_exists('use_phone', $inputs) || $inputs['phone_number'] == ""))
            $inputs['use_phone'] = 0;

        return $inputs;
    }
}
