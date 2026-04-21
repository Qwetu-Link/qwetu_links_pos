<?php

namespace App\Models\payment;

use Database\Factories\Payment\TransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'transaction_id',
        'ref_code',
        'payment_method',
        'trans_code',
        'amount',
        'trans_type',
        'status',
        'customer_id',
        'date',
        'notes',
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
            if (empty($model->transaction_id)) {
                $model->transaction_id = self::generateTransactionId();
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Sequential business ID
    private static function generateTransactionId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->transaction_id) {
            return 'TXN-0001';
        }

        // Extract number from CAT-0001
        $lastNumber = (int) substr($last->transaction_id, 4);

        return 'TXN-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}
