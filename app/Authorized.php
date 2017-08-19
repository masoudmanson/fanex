<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorized extends Model
{
    protected $table = 'authorized';

    protected $fillable = [
      'firstname',
      'lastname',
      'identifier_id',
      'identity_number',
      'identity_type',
      'mobile',
    ];
}
