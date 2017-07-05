<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $dates = [
        'payment_date'
    ];

    public function setPaymentDateAttribute($value)
    {
        $this->attributes['payment_date'] = Carbon::createFromTimestamp($value)->toDateTimeString();
    }

    public function scopeFindByBillNumber($query, $billNumber)
    {
        return $query->where('uri', $billNumber); //unique ref. number
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function beneficiary()
    {
        return $this->belongsTo('App\Beneficiary');
    }

    public function backlog()
    {
        return $this->belongsTo('App\Backlog');
    }
}
