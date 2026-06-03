<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:vendors,phone',
            'email' => 'nullable|email|max:255|unique:vendors,email',
            'national_id' => 'required|string|max:50|unique:vendors,national_id',
            'business_type' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'registration_date' => 'required|date',
            'status' => 'required|in:active,inactive,suspended',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.unique' => 'This phone number is already registered.',
            'national_id.unique' => 'This National ID is already registered.',
        ];
    }
}
