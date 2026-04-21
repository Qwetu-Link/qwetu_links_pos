<?php

namespace App\Models\order;

use Database\Factories\Order\LipaMdogoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LipaMdogo extends Model
{
    /** @use HasFactory<LipaMdogoFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'plan_id',
        'order_id',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'installments',
        'installment_amount',
        'frequency',
        'next_payment_date',
        'status',
        'payment_method',
        'start_date',
        'days_overdue',
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
            if (empty($model->plan_id)) {
                $model->plan_id = self::generatePlanId();
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Sequential business ID
    private static function generatePlanId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->plan_id) {
            return 'PLN-0001';
        }

        // Extract number from CAT-0001
        $lastNumber = (int) substr($last->plan_id, 4);

        return 'PLN-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function order()
    {
        $this->belongsTo(Orders::class);
    }
}
