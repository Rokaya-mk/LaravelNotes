<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
 Route::post('register', 'App\Http\Controllers\Api\RegisterController@register');
 Route::post('login', 'App\Http\Controllers\Api\RegisterController@login');
Route::middleware('auth:api')->group( function (){
    Route::resource('notes', 'App\Http\Controllers\Api\NoteController');
    Route::delete('notes/softdelete/{id}', 'App\Http\Controllers\Api\NoteController@softDelete');
    Route::patch('notes/restore/{id}', 'App\Http\Controllers\Api\NoteController@restore');
    Route::delete('notes/deleteSoftDeleted/{id}', 'App\Http\Controllers\Api\NoteController@deleteSoftDeleted');
});

