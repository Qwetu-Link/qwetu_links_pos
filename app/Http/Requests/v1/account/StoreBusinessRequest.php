<?php

namespace App\Http\Requests\v1\account;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|regex:/^\+254[71]\d{8}$/',
            'location' => 'required|string|max:100',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'business_name' => $this->businessName,
        ]);
    }
}
