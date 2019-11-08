<?php

namespace App\Models;

use App\Models\Traits\CanBeDefault;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use CanBeDefault;

    protected $casts =[
        'default' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'default',
        'address_1',
        'city',
        'postal_code',
        'country_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
