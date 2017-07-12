<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public function scopeFindByCountryCode($query,$code)
    {
        return $query->where('code', $code);
    }
}
