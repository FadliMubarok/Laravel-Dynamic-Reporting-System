<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use App\Report;

class ReportController extends Controller
{
    public function index(){
        return Report::get();
    }

    public function show($id){
        $report = Report::findOrFail($id);
        $report->load('sort_field:fields.id,fields.label');
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

        // Select
        $fields = $report->fields->pluck('name')->toArray();
        $query = $model::select($fields);

        // Rules
        foreach($report->rules as $rule) {
            $query->orWhere(function($query) use ($rule){
                foreach($rule->conditions as $condition) {
                    $this->whereConditions($query, $condition);
                }
            });
        }

        // Sorting
        if($report->sort_field_id){
            $query->orderBy($report->sort_field->name, $report->sort_direction);
        }

        return $query->paginate(request('limit', 100));
    }

    private function whereConditions($query, $condition){
        switch($condition->type) {
            case 'equals':
                $query->where($condition->field->name, $condition->value);
                break;
            case 'contains':
                $query->where($condition->field->name, 'like', "%{$condition->value}%");
                break;
            case 'starts_with':
                $query->where($condition->field->name, 'like', "{$condition->value}%");
                break;
            case 'ends_with':
                $query->where($condition->field->name, 'like', "%{$condition->value}");
                break;
            case 'less_then':
                $query->where($condition->field->name, '<', $condition->value);
                break;
            case 'less_then_or_equal':
                $query->where($condition->field->name, '<=', $condition->value);
                break;
            case 'greater_then':
                $query->where($condition->field->name, '>', $condition->value);
                break;
            case 'greater_then_or_equal':
                $query->where($condition->field->name, '>=', $condition->value);
                break;
            case 'month_equal':
                $query->whereMonth($condition->field->name, '=', $condition->value);
                break;
        }
    }

    public function save(){

        request()->validate([
            'id' => 'exists:reports,id',
            'name' => 'required|max:255',
            'model' => 'required|exists:fields,model',
            'sort_field_id' => 'exists:fields,id',
            'sort_direction' => [ValidationRule::in(['asc', 'desc'])],
            'fields' => 'required|array|exists:fields,id',
            'rules' => 'array|exists:rules,id'
        ]);
        
        $report = request('id') ? Report::Find(request('id')) : new Report;
        $report->model = request('model');
        $report->name = request('name');
        $report->sort_field_id = request('sort_field_id');
        $report->sort_direction = request('sort_direction');
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
