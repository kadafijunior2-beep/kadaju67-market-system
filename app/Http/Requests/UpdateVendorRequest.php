<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vendorId = $this->route('vendor');

        return [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:vendors,phone,' . $vendorId,
            'email' => 'nullable|email|max:255|unique:vendors,email,' . $vendorId,
            'national_id' => 'required|string|max:50|unique:vendors,national_id,' . $vendorId,
            'business_type' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'registration_date' => 'required|date',
            'status' => 'required|in:active,inactive,suspended',
        ];
    }
}
