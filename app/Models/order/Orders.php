<?php

namespace App\Models\order;

use Database\Factories\Order\OrdersFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    /** @use HasFactory<OrdersFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'order_id',
        'customer',
        'email',
        'phone',
        'items',
        'total',
        'payment_type',
        'status',
        'created_at_date',
        'shipping_address',
        'business_id',
        'branch_id',
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
            if (empty($model->order_id)) {
                $model->order_id = self::generateOrderId();
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Sequential business ID
    private static function generateOrderId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->order_id) {
            return 'ORD-0001';
        }

        // Extract number from CAT-0001
        $lastNumber = (int) substr($last->order_id, 4);

        return 'ORD-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function plans()
    {
        return $this->hasMany(LipaMdogo::class);
    }
}
