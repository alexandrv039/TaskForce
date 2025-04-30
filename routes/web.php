<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [\App\Http\Controllers\Controller::class, 'index'])->name('index');

Route::get('/home', [App\Http\Controllers\TaskController::class, 'index'])->name('home');
