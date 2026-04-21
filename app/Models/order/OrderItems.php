<?php

namespace App\Models\order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    /** @use HasFactory<\Database\Factories\Order\OrderItemsFactory> */
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'order_id',
        'product_name',
        'quantity',
        'price',
        'total'
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
            if (empty($model->order_item_id)) {
                $model->order_item_id = self::generateOrderItemId();
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Sequential business ID
    private static function generateOrderItemId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->order_item_id) {
            return 'LIT-0001';
        }

        // Extract number from CAT-0001
        $lastNumber = (int) substr($last->order_item_id, 4);

        return 'LIT-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
