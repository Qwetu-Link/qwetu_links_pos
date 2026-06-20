<?php

namespace App\Models\product;

use App\Models\inventory\Inventory;
use App\Models\inventory\InventoryLocation;
use Database\Factories\Product\ProductVariantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    /** @use HasFactory<ProductVariantFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'variant_id',
        'product_id',
        'sku',
        'color',
        'size',
        'buy_price',
        'sell_price',
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

            // Variant ID (CAT-0001)
            if (empty($model->variant_id)) {
                $model->variant_id = self::generateVariantId();
            }

            // SKU generation
            if (empty($model->sku)) {
                $model->sku = self::generateSKU($model);
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Sequential business ID
    private static function generateVariantId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->variant_id) {
            return 'VAR-0001';
        }

        // Extract number from CAT-0001
        $lastNumber = (int) substr($last->variant_id, 4);

        return 'VAR-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    private static function generateSKU($model)
    {
        // $productId = $model->product_id ?? 'VAR';

        $colorPart = $model->color
            ? strtoupper(substr($model->color, 0, 2))
            : 'GEN';

        $sizePart = $model->size
            ? strtoupper($model->size)
            : 'NA';

        // Ensure uniqueness
        do {
            $random = strtoupper(substr(uniqid(), -4));
            $sku = "VAR-{$colorPart}-{$sizePart}-{$random}";
            // $sku = "PRD-{$productId}-{$colorPart}-{$sizePart}-{$random}";
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }

    public function product()
    {
        return $this->belongsTo(ProductCatalog::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    // public function locations()
    // {
    //     return $this->hasMany(InventoryLocation::class);
    // }
}
