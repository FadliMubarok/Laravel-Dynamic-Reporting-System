<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('models', 'ModelController@index');
Route::get('models/{model}/fields', 'ModelController@show');

Route::get('reports', 'ReportController@index');
Route::get('reports/{id}', 'ReportController@show');
Route::get('reports/{id}/data', 'ReportController@data');
Route::post('reports', 'ReportController@save');
Route::delete('reports/{id}', 'ReportController@delete');

Route::get('rules/condition/types', 'RuleController@conditionTypes');
Route::get('models/{model}/rules', 'RuleController@index');
Route::get('rules/{id}', 'RuleController@show');
Route::post('rules', 'RuleController@save');
Route::delete('rules/{id}', 'RuleController@delete');
