<?php

namespace App\Http\Requests\v1\product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
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
            'product_id' => 'required|exists:product_catalogs,id',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:20',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0|gte:buy_price',
            'is_available' => 'required|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_available' => $this->isAvailable,
            'buy_price' => $this->buyPrice,
            'sell_price' => $this->sellPrice,
            'product_id' => $this->productId,
        ]);
    }
}
