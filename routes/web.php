<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/welcome', [\App\Http\Controllers\Controller::class, 'index'])->name('welcome');

Route::get('/', [App\Http\Controllers\TaskController::class, 'list'])->name('index');
