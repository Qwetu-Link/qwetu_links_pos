<?php

namespace App\Models\auth;

use App\Models\account\Business;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\Auth\RoleFactory> */
    use HasFactory;

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'role_name',
        'business_id',
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

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
