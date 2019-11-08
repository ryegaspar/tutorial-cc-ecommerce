<?php

namespace App\Models\Traits;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;

trait CanBeDefault
{

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->default) {
                $model->newQuery()->where('user_id', $model->user->id)->update([
                    'default' => false
                ]);
            }
        });
    }

    public function setDefaultAttribute($value)
    {
        $this->attributes['default'] = ($value === 'true' || $value ? true : false);
    }
}
