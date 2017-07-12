<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $table = 'beneficiaries';

    protected $fillable = [
        'user_id','firstname', 'lastname', 'account_number', 'country', 'address', 'tel', 'fax', 'bank_name', 'branch_name', 'swift_code', 'iban_code'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_deleted', 0);
    }

}
