<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product' => 'required|array',
            'product.name' => 'required',
            'product.description' => 'required|max:255',
            'product.prices' => 'required|array',
        ];

        if (isset($this->request->get('product')['prices'])) {
            foreach ($this->request->get('product')['prices'] as $key => $val) {
                $rules['product.prices.' . $key . '.type_id'] = 'required|integer';
                $rules['product.prices.' . $key . '.price'] = 'required|integer';
            }
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product.prices.required' => 'The :attribute field is required.',
        ];
    }
}
