<?php

namespace App\Http\Controllers;
use App\Field;

use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function models(){
        return Field::select('model')->groupBy('model')->get();
    }
    public function fields($model){
        return Field::where('model', $model)->get();
    }
}
