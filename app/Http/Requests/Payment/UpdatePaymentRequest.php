<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => ['required', 'integer'],
            'description' => ['required', 'string', 'min:3', 'max:256'],
            'id' => ['required', 'integer'],
        ];
    }
}
