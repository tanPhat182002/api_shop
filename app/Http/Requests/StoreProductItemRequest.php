<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'items' => 'required|array',
            'items.*.color' => 'required|string|max:20',
            'items.*.size' => 'required|string|max:20',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
