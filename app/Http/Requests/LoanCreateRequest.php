<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:50'],
            'annual_interest_rate' => ['required', 'numeric', 'min:0.1', 'max:100'],
            'loan_term' => ['required', 'numeric', 'min:0.25'],
            'monthly_fixed_extra_payment' => ['sometimes', 'numeric', 'min:0.1'],
        ];
    }
}