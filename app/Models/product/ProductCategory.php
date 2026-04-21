<?php

namespace App\Models\product;

use Database\Factories\Product\ProductCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /** @use HasFactory<ProductCategoryFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'category_id',
        'name',
        'icon',
        'description',
        'business_id',
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
            if (empty($model->category_id)) {
                $model->category_id = self::generateCategoryId();
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Sequential business ID
    private static function generateCategoryId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->category_id) {
            return 'CAT-0001';
        }

        // Extract number from CAT-0001
        $lastNumber = (int) substr($last->category_id, 4);

        return 'CAT-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function category()
    {
        return $this->hasMany(ProductCatalog::class);
    }
}
