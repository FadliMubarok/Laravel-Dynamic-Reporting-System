<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{    
    public function fields(){
        return $this->belongsToMany('App\Field', 'report_fields');
    }
    public function rules(){
        return $this->belongsToMany('App\Rule', 'report_rules');
    }
}
