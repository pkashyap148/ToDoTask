<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\IndexController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
}); */


//Route::match(['get','post'],'/','App\Http\Controllers\ListController@index');
Route::match(['get','post'],'/','App\Http\Controllers\ListController@index');
Route::post('/','App\Http\Controllers\ListController@store');
// Route::view('/','list.index');
Route::get('/','App\Http\Controllers\ListController@index');
Route::post('/{task_id}',[ListController::class,'delete']);
Route::post('/{task_id}/{newTask}', [ListController::class, 'editTask']);
Route::post('/{task_id}/status/{status}', [ListController::class, 'status']);
Route::post('/{task_id}/priority/{priority}', [ListController::class, 'priority']);



