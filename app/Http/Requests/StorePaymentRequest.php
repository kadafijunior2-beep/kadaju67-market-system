<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => 'required|exists:vendors,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,check',
            'reference_number' => 'required|string|max:100|unique:payments,reference_number',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed,failed,refunded',
        ];
    }
}
