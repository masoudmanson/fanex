<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
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
