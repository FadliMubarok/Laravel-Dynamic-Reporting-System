<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RuleCondition extends Model
{
    protected $fillable = ['rule_id', 'field_id', 'type', 'value'];
    public $timestamps = false;

    public function field()
    {
        return $this->belongsTo('App\Field');
    }
}
