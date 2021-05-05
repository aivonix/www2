<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::resource('/application', App\Http\Controllers\ApplicationController::class)->middleware('auth');
Route::get('/application', [App\Http\Controllers\ApplicationController::class, 'index'])->middleware('auth');
Route::post('/application', [App\Http\Controllers\ApplicationController::class, 'store'])->middleware('auth');
Route::get('/application/create', [App\Http\Controllers\ApplicationController::class, 'create'])->middleware('auth');
Route::put('/application/{application}', [App\Http\Controllers\ApplicationController::class, 'update'])->middleware('auth');
Route::get('/application/{application}/edit', [App\Http\Controllers\ApplicationController::class, 'edit'])->middleware('auth');
Route::get('/application/list', [App\Http\Controllers\ApplicationController::class, 'list'])->middleware('auth');
