<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $stallId = $this->route('stall');

        return [
            'stall_number' => 'required|string|max:50|unique:stalls,stall_number,' . $stallId,
            'location' => 'required|string|max:255',
            'size' => 'nullable|string|max:100',
            'monthly_rent' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ];
    }
}
