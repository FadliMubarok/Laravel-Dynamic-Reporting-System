<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use App\Rule;

class RuleController extends Controller
{
    private $types = ['ends_with', 'year_equal'];

    public function show($id){
        $rule = Rule::findOrFail($id);
        $rule->load('conditions');
        return $rule;
    }

    public function save(){

        request()->validate([
            'id' => 'exists:rules,id',
            'name' => 'max:255',
            'model' => 'required|exists:fields,model',
            'conditions' => 'required|array',
            'conditions.*.field_id' => 'required|exists:fields,id',
            'conditions.*.type' => ['required', ValidationRule::in($this->types)],
            'conditions.*.value' => 'required'
        ]);

        $id = request('id');

        $rule = $id ? Rule::Find($id) : new Rule;
        $rule->name = request('name');
        $rule->model = request('model');
        if($rule->save()){
            if($id) $rule->conditions()->delete();
            $rule->conditions()->createMany(request('conditions'));
        }

        return $rule;
    }
}
