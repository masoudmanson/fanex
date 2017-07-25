<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    public function scopeEur($query)
    {
        return $query->where('currency_type','EUR');
    }

    public function scopeLast($query, $currency)
    {
        return $query->where('type' , $currency)->first();
    }

    public function rates()
    {
        return $this->hasMany('App\Rate');
    }
}
