<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class ReportController extends Controller
{
    public function get($id){
        $report = Report::findOrFail($id);
        $report->load('fields:fields.id,fields.label');
        $report->load('rules');
        return $report;
    }

    public function save(){

        request()->validate([
            'name' => 'required|max:255',
            'model' => 'required|exists:fields,model',
            'fields' => 'required|array|exists:fields,id',
            'rules' => 'array|exists:rules,id'
        ]);

        $report = new Report;
        $report->model = request('model');
        $report->name = request('name');
        if($report->save()){
            $report->fields()->sync(request('fields'));
            $report->rules()->sync(request('rules'));
        }

        return $report;
    }
}
