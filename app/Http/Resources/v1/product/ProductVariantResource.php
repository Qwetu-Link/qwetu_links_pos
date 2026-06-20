<?php

namespace App\Http\Resources\v1\product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'variantId' => $this->variant_id,
            'productId' => $this->product_id,
            'sku' => $this->sku,
            'color' => $this->color,
            'size' => $this->size,
            'buyPrice' => $this->buy_price,
            'sellPrice' => $this->sell_price,
            'isAvailable' => $this->is_available,
        ];
    }
}
