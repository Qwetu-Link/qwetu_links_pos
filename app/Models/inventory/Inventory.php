<?php

namespace App\Models\inventory;

use App\Models\product\ProductVariant;
use Database\Factories\Inventory\InventoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /** @use HasFactory<InventoryFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'variant_id',
        'total_stock',
        'reorder_point',
        'status',
        'last_restocked',
    ];

    protected $casts = [
        'last_restocked' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {

            // Primary ID (random secure ID)
            if (empty($model->id)) {
                $model->id = self::generateRandomID();
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Relationships
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // Optional: Auto status accessor
    public function getComputedStatusAttribute()
    {
        if ($this->total_stock == 0) {
            return 'out_of_stock';
        }

        if ($this->total_stock <= $this->reorder_point) {
            return 'low';
        }

        return 'healthy';
    }

    public function locations()
    {
        return $this->belongsToMany(
            InventoryLocation::class,
            'inventory_location_items',
            'inventory_id',
            'inventory_location_id'
        )->withPivot('quantity')->withTimestamps();
    }
}
