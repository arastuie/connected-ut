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
            'title' => 'required_with:title|min:4|max:200',
            'condition' => 'numeric',
            'available_by' => 'date|after:yesterday',
            'price' => 'numeric|regex:/^\d{0,8}(\.\d{1,2})?$/',
            'edition' => 'max:50',
            'ISBN_13' => 'max:20',
            'ISBN_10' => 'max:20',
            'publisher' => 'max:100',
            'published_year' => 'numeric',
            'obo' => 'boolean',
            'photo' => 'between:5,4000|image|mimes:jpeg,png',
        ];

        // Not empty if present
        foreach(['title', 'condition', 'available_by', 'price'] as $field)
        {
            if($this->request->has($field))
                $rules[$field] .= '|required';
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
        $messages['photo.between'] = "The photo must be between 5KB and 4MB in size.";
        $messages['photo.mimes'] = "The photo's type should be either jpeg, jpg or png.";
        $messages['after'] = 'The :attrbute cannot be a date from past.';

        return $messages;
    }

}
