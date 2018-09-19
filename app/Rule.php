<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $hidden = ['pivot'];
    
    public function conditions()
    {
        return $this->hasMany('App\RuleCondition');
    }
}
