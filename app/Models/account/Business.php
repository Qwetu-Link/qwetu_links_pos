<?php

namespace App\Models\account;

use App\Models\auth\Role;
use App\Models\auth\User;
use Database\Factories\Account\BusinessFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    /** @use HasFactory<BusinessFactory> */
    use HasFactory;

    public $incrementing = false; // Disable auto-increment

    protected $keyType = 'string';

    protected $fillable = [
        'business_name',
        'location',
        'contact',
        'email',
        'tax_settings',
        'tax_pin',
        'bank_name',
        'branch',
        'account_number',
        'account_name',
        'mpesa_paybill',
        'mpesa_till_no',
        'is_active',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generateRandomID();
            }
        });
    }

    private static function generateRandomID()
    {
        return bin2hex(random_bytes(6)); // 12-character unique ID
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
