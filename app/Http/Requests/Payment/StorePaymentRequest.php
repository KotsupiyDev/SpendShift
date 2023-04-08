<?php

namespace App\Http\Requests\Payment;

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
            'category_id' => ['required', 'integer'],
            'value' => ['required', 'integer'],
            'description' => ['required', 'string', 'min:3', 'max:256'],
            'type' => ['required', 'string', 'in:Income,Expense'],
        ];
    }
}
