<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'persons' => 'required|integer|min:1|max:50',
            'date_time' => 'required|date|after:now',
            'intolerances' => 'nullable|string|max:1000',
            'honey_pot' => 'max:0|nullable', // Simple honeypot check
        ];
    }
}
