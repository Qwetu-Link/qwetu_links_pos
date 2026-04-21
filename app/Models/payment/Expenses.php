<?php

namespace App\Models\payment;

use Database\Factories\Payment\ExpensesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    /** @use HasFactory<ExpensesFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'expense_id',
        'category',
        'amount',
        'date',
        'method',
        'description',
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
            if (empty($model->expense_id)) {
                $model->expense_id = self::generateExpenseId();
            }
        });
    }

    // Secure random ID (primary key)
    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // e.g. a3f9b1c4d8e2
    }

    // Sequential business ID
    private static function generateExpenseId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->expense_id) {
            return 'EXP-0001';
        }

        // Extract number from CAT-0001
        $lastNumber = (int) substr($last->expense_id, 4);

        return 'EXP-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}
