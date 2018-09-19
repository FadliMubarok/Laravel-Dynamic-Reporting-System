<?php

namespace App\Http\Controllers;
use App\Field;

use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index(){
        return Field::select('model')->groupBy('model')->get();
    }
    public function show($model){
        return Field::where('model', $model)->get();
    }
}
