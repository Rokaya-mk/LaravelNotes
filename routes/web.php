<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/notes', 'App\Http\Controllers\Web\NoteController@index' )->name('notes');


Route::get('/s/show/{id}', 'App\Http\Controllers\Web\NoteController@show' )->name('notes.show');
Route::get('/notes/edit/{id}', 'App\Http\Controllers\Web\NoteController@edit' )->name('notes.edit');
Route::put('/notes/update/{note}', 'App\Http\Controllers\Web\NoteController@update' )->name('notes.update');
Route::get('/notes/destroy/{id}', 'App\Http\Controllers\Web\NoteController@destroy' )->name('notes.destroy');
Route::get('/notes/softdelete/{id}', 'App\Http\Controllers\Web\NoteController@softDelete')->name('notes.softDelete');
Route::get('/notes/deleteSoftDeleted/{id}', 'App\Http\Controllers\Web\NoteController@deleteSoftDeleted' )->name('notes.deleteSoft');


Route::middleware('is_admin')->group(function(){
    Route::get('/notes/create', 'App\Http\Controllers\Web\NoteController@create' )->name('notes.create');
    Route::post('/notes/store', 'App\Http\Controllers\Web\NoteController@store' )->name('notes.store');
    Route::get('/notes/restore/{id}', 'App\Http\Controllers\Web\NoteController@restore' )->name('notes.restore');
    Route::get('/notes/trashed', 'App\Http\Controllers\Web\NoteController@notesTrashed' )->name('notes.trashed');
});