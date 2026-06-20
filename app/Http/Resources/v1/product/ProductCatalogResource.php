<?php

namespace App\Http\Resources\v1\product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCatalogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productId' => $this->product_id,
            'name' => $this->name,
            'categoryId' => $this->category_id,
            'brand' => $this->brand,
            'description' => $this->description,
            'imageUrl' => $this->image_url,
            'isAvailable' => $this->is_available,
            'variants' => ProductVariantResource::collection($this->variant),
        ];
    }
}
