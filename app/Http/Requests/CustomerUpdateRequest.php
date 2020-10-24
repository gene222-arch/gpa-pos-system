<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; 
        // \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar' => ['nullable', 'image', 'max:1999', 'mimes:png,jpg,jpeg'],
            'first_name' => ['required', 'string', 'min:2', 'max:50'],
            'last_name' => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['email'],
            'address' => ['required', 'min:10', 'max:95']
        ];
    }


// Default method
// Validator $validator -- constains all error messages
    protected function failedValidation(Validator $validator)
    {

    // expects a request in JSON format
        if ( $this->expectsJson() ) {

        // Must pass the validator object in order to access the errors in it
            $validation = new ValidationException($validator);

        // errors() ---> Get all of the validation error messages.
            throw new HttpResponseException(
                response()->json($validation->errors(), 422)
            );
        }

    // Urlencoded Data
        parent::failedValidation($validator);
    }


}
