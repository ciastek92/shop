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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'product' =>'required|array',
            'product.name' => 'required',
            'product.description' => 'required|max:255',
            'product.prices' => 'required|array',
        ];

          foreach($this->request->get('product.prices') as $key => $val)
          {
              $rules['product.prices.'.$key . 'type'] = 'required|integer';
              $rules['product.prices.'.$key . 'price'] = 'required|integer';
          }

    }
}
