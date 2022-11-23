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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function() {
    Route::post('task/create',[\App\Http\Controllers\TodoController::class, 'store'])->name('task.create');
    Route::get('task/edit/{taskId}',[\App\Http\Controllers\TodoController::class, 'edit']);
    Route::post('task/update/{taskId}', [\App\Http\Controllers\TodoController::class, 'update'])->name('task.update');
    Route::delete('task/delete/{taskId}',[\App\Http\Controllers\TodoController::class, 'destroy'])->name('task.delete');
});
