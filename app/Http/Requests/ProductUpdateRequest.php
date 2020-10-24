<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUpdateRequest extends FormRequest
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
            'product_name' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string', 'min:10', 'max:255'],
            'image' => ['nullable', 'image', 'max:1999', 'mimes:png,jpg,jpeg'],
            'barcode' => ['required', 'string'],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'status' => ['boolean']
        ];
    }

    
    protected function failedValidation( Validator $validator ) {

        if ( $this->expectsJson() ) {

            $validate = new ValidationException($validator);
            
            throw new HttpResponseException(
                response()->json($validate->errors(), 422)
            );
        }

        parent::failedValidation($validator);
    }


}
