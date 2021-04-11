<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'sku' => ['required', Rule::unique('products', 'sku')],
            'image' => ['nullable', 'mimes:jpg,png'],
            'qty' => ['required', 'integer', 'min:1'],
            'description' => ['required'],
            'short_description' => ['nullable', 'max:255'],
        ];
    }
}
