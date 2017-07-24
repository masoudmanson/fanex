<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function scopeEur($query)
    {
        return $query->where('currency_type','EUR');
    }
}
