<?php

namespace App\Models\product;

use Database\Factories\Product\ProductCatalogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCatalog extends Model
{
    /** @use HasFactory<ProductCatalogFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'product_id',
        'name',
        'category_id',
        'brand',
        'description',
        'image_url',
        'business_id',
        'branch_id',
        'is_available',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {

            // Primary ID (random secure ID)
            if (empty($model->id)) {
                $model->id = self::generateRandomID();
            }

            // Business ID (CAT-0001)
            if (empty($model->product_id)) {
                $model->product_id = self::generateProductId();
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Sequential business ID
    private static function generateProductId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->product_id) {
            return 'PRD-0001';
        }

        // Extract number from CAT-0001
        $lastNumber = (int) substr($last->product_id, 4);

        return 'PRD-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
