<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class BookRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		switch($this->method())
        {
            case 'POST':
            {
                return (Auth::check());
            }

            case 'PUT':
            {
                $book = $this->route('books');
                return ($book->user_id === Auth::id());
            }

            default:
            {
                return false;
            }
        }
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{

        $rules = [
            'title' => 'required|min:4|max:200',
            'condition' => 'required|numeric',
            'available_by' => 'required|date|after:yesterday',
            'price' => 'required|numeric|regex:/^\d{0,8}(\.\d{1,2})?$/',
            'pics' => 'array',
            'edition' => 'max:50',
            'ISBN_13' => 'max:20',
            'ISBN_10' => 'max:20',
            'publisher' => 'max:100',
            'published_year' => 'numeric'
        ];

        foreach($this->files->get('pics') as $key => $pic)
        {
            $rules['pics.' . $key] = 'max:4000|image|mimes:jpeg,png';
        }

        return $rules;
	}

    /**
     * Custom error messages
     *
     * @return array
     */
    public function messages()
    {
        $messages = [];

        foreach($this->files->get('pics') as $key => $pic)
        {
            $messages['pics.' . $key . '.between'] = 'Photo ' . ($key + 1) . ' should be less them 4MB.';
            $messages['pics.' . $key . '.mimes'] = 'Photo ' . ($key + 1) . '\'s type should be either jpeg or png.';
        }

        $messages['after'] = 'The :attribute cannot be a date from past.';

        return $messages;
    }

}
