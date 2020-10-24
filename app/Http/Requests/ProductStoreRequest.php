<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:1999'],
            'barcode' => ['required', 'regex:/GPA-[0-9]{3,}$/'],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'status' => ['boolean']
        ];
    }
}
