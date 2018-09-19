<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class ReportController extends Controller
{
    public function index(){
        return Report::get();
    }

    public function show($id){
        $report = Report::findOrFail($id);
        $report->load('fields:fields.id,fields.label');
        $report->load('rules.conditions.field:fields.id,fields.label');
        return $report;
    }

    public function data($id){
        $report = Report::findOrFail($id);

        $model = "App\\{$report->model}";
        if(!class_exists($model)){
            return response()->json(['error' => 'model_unavailable'], 500);
        }

        $fields = $report->fields->pluck('name')->toArray();
        $query = $model::select($fields);

        foreach($report->rules as $rule) {
            $query->orWhere(function($query) use ($rule){
                foreach($rule->conditions as $condition) {
                    if($condition->type == 'ends_with'){
                        $query->where($condition->field->name, 'like', "%{$condition->value}");
                    }
                    else if($condition->type == 'year_equal'){
                        $query->whereYear($condition->field->name, '=', $condition->value);
                    }
                }
            });
        }

        //dd($query->toSql());
        $limit = request()->has('limit') ? request('limit') : 100;
        $results = $query->paginate($limit);
        return $results;
    }

    public function save(){

        request()->validate([
            'name' => 'required|max:255',
            'model' => 'required|exists:fields,model',
            'fields' => 'required|array|exists:fields,id',
            'rules' => 'array|exists:rules,id'
        ]);

        $id = request('id');

        $report = $id ? Report::Find($id) : new Report;
        $report->model = request('model');
        $report->name = request('name');
        if($report->save()){
            $report->fields()->sync(request('fields'));
            $report->rules()->sync(request('rules'));
        }

        return $report;
    }

    public function delete($id){
        $report = Report::findOrFail($id);
        $report->fields()->detach();
        $report->rules()->detach();
        $report->delete();
    }
}
