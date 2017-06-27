<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function scopeFindByCountryCode($query,$code)
    {
        return $query->where('code', $code);
    }
}
