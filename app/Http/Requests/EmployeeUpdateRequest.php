<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeUpdateRequest extends FormRequest
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
            'first_name' =>['required', 'string', 'min:2', 'max:50'],
            'last_name' => ['required', 'string', 'min:2', 'max:50'],
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'email' => ['required', 'email', 'min:15', 'max:50'],
            'phone' => ['required', 'regex:/([0-9]{3}-[0-9]{2}-[0-9]{3})/'],
            'salary' => ['required'],
            'commission' => ['required']

        ];
    }

    protected function failedValidation (Validator $validator) {

        if ($this->expectsJson()) {

            $validationException = new ValidationException($validator);
            
            throw new HttpResponseException(
                response()->json(
                    $validationException->errors(), 422
                )
            );
        }

        parent::failedValidation($validator);
    }

}
