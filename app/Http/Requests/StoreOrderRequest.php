<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|string|in:cash,card',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required',
            'products.*.quantity' => 'required|integer|min:1',
            'honey_pot' => 'max:0|nullable',
        ];
    }
}
