<?php

namespace App\Models\payment;

use App\Models\account\Customer;
use App\Models\order\Orders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\Payment\InvoiceFactory> */
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'customer_id',
        'invoice_number',
        'amount',
        'paid_amount',
        'balance',
        'issue_date',
        'due_date',
        'status',
        'notes',
        'business_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->id)) {
                $model->id = self::generateRandomID();
            }

            if (empty($model->invoice_number)) {
                $model->invoice_number = self::generateInvoiceId();
            }
        });
    }

    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6));
    }

    private static function generateInvoiceId()
    {
        $last = self::orderBy('created_at', 'desc')->first();

        if (! $last || ! $last->invoice_number) {
            return 'INV-0001';
        }

        $lastNumber = (int) substr($last->invoice_number, 4);

        return 'INV-'.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function payment()
    {
        return $this->hasMany(Transaction::class);
    }

     public function cutomer()
    {
        return $this->belongsTo(Customer::class);
    }

     public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
