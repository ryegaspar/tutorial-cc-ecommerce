<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $casts =[
        'default' => 'boolean'
    ];

    protected $fillable = [
        'cart_type',
        'last_four',
        'provider_id',
        'default'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($paymentMethod) {
            if ($paymentMethod->default) {
                $paymentMethod->user->paymentMethods()->update([
                    'default' => false
                ]);
            }
        });
    }

    public function setDefaultAttribute($value)
    {
        $this->attributes['default'] = ($value === 'true' || $value ? true : false);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
