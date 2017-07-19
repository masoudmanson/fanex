<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Identifier extends Model
{
    protected $table = 'identifiers';

    const NAME = 'fanapium';
//    const FIELD_1 = 'international_code';
//    const FIELD_2 = 'mobile';
    const STATUS = TRUE;

    protected $attributes = [
        'name' => self::NAME,
//        'field_1' => self::FIELD_1,
//        'field_2' => self::FIELD_2,
        'status' => self::STATUS,
    ];

}
