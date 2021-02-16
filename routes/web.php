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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/notes', 'App\Http\Controllers\Web\NoteController@index' )->name('notes');
Route::get('/note/create', 'App\Http\Controllers\Web\NoteController@create' )->name('note.create');
Route::post('/note/store', 'App\Http\Controllers\Web\NoteController@store' )->name('note.store');
Route::get('/note/show/{id}', 'App\Http\Controllers\Web\NoteController@show' )->name('note.show');
Route::get('/note/edit/{id}', 'App\Http\Controllers\Web\NoteController@edit' )->name('note.edit');
Route::put('/note/update/{note}', 'App\Http\Controllers\Web\NoteController@update' )->name('note.update');
Route::get('/note/destroy/{id}', 'App\Http\Controllers\Web\NoteController@destroy' )->name('note.destroy');
Route::get('/note/softdelete/{id}', 'App\Http\Controllers\Web\NoteController@softDelete')->name('note.softDelete');
Route::get('/note/deleteSoftDeleted/{id}', 'App\Http\Controllers\Web\NoteController@deleteSoftDeleted' )->name('note.deleteSoft');
Route::get('/note/restore/{id}', 'App\Http\Controllers\Web\NoteController@restore' )->name('note.restore');
Route::get('/notes/trashed', 'App\Http\Controllers\Web\NoteController@notesTrashed' )->name('notes.trashed');

