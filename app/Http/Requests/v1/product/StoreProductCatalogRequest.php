<?php

namespace App\Http\Requests\v1\product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductCatalogRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'category_id' => 'required|string',
            'brand' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'is_available' => 'required|boolean',

            'color' => 'nullable|array',
            'color.*' => 'nullable|string|max:50',

            'size' => 'nullable|array',
            'size.*' => 'nullable|string|max:20',

            'buy_price' => 'required|array',
            'buy_price.*' => 'required|numeric|min:0',

            'instock' => 'required|array',
            'instock.*' => 'required|numeric|min:0',

            'sell_price' => 'required|array',
            'sell_price.*' => 'required|numeric|min:0',

            'product_id' => 'nullable|array',
            'product_id.*' => 'required|string|exists:product_catalogs,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'category_id' => $this->categoryId,
            'image_url' => $this->imageUrl,
            'is_available' => $this->isAvailable,
            'buy_price' => $this->buyPrice,
            'sell_price' => $this->sellPrice,
            'product_id' => $this->productId,
        ]);
    }
}
