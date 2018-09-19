<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConditionType extends Model
{
    protected $casts = [
        'available_in' => 'array'
    ];
}
