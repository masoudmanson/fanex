<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Backlog extends Model
{
    public function setTtlAttribute($value)
    {
        $this->attributes['ttl'] = Carbon::createFromTimestamp($value)->toDateTimeString();
    }

    public function setUpt_ttlAttribute($value)
    {
        $this->attributes['upt_ttl'] = Carbon::createFromTimestamp($value)->toDateTimeString();
    }

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }

}
