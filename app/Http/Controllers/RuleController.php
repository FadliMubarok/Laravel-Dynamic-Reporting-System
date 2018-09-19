<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use App\Rule;
use App\ConditionType;

class RuleController extends Controller
{
    public function show($id){
        $rule = Rule::findOrFail($id);
        $rule->load('conditions');
        return $rule;
    }

    public function index($model){
        return Rule::where('model', $model)->get();
    }

    public function save(){

        request()->validate([
            'id' => 'exists:rules,id',
            'name' => 'max:255',
            'model' => 'required|exists:fields,model',
            'conditions' => 'required|array',
            'conditions.*.field_id' => 'required|exists:fields,id',
            'conditions.*.type' => 'required|exists:condition_types,name',
            'conditions.*.value' => 'required'
        ]);

        $rule = request('id') ? Rule::Find(request('id')) : new Rule;
        $rule->name = request('name');
        $rule->model = request('model');
        if($rule->save()){
            $rule->conditions()->delete();
            $rule->conditions()->createMany(request('conditions'));
        }

        return $rule;
    }

    public function delete($id){
        $rule = Rule::findOrFail($id);
        $rule->conditions()->delete();
        $rule->delete();
    }

    public function conditionTypes(){
        $query = ConditionType::select();
        if(request('type')){
            $query->whereJsonContains('available_in', request('type'));
        }
        return $query->get();
    }
}
