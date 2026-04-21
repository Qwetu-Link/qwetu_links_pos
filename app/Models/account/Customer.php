<?php

namespace App\Models\account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\Account\CustomerFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'total_orders',
        'total_spent',
        'active_installments',
        'payment_score',
        'risk_level',
        'segment',
        'joined_date',
        'last_purchase',
        'address',
        'business_id',
        'branch_id',
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
            if (empty($model->customer_id)) {
                $model->customer_id = self::generateCustomerId();
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Sequential business ID
    private static function generateCustomerId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->customer_id) {
            return 'CUST-0001';
        }

        // Extract number from CAT-0001
        $lastNumber = (int) substr($last->customer_id, 4);

        return 'CUST-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}
