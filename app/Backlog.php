<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Backlog extends Model
{
    protected $table = 'backlogs';

    public function setTtlAttribute($value)
    {
        $this->attributes['ttl'] = Carbon::createFromTimestamp($value)->toDateTimeString();
    }

    public function setUptTtlAttribute($value)
    {
        $this->attributes['upt_ttl'] = Carbon::createFromTimestamp($value)->toDateTimeString();
    }

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }

}
