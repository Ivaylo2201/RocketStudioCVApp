<?php

use App\Http\Controllers\CVFormController;
use App\Http\Controllers\CVTableController;
use Illuminate\Support\Facades\Route;

Route::get('', [CVFormController::class, 'show']);
Route::post('', [CVFormController::class, 'store'])->name('form.submit');
Route::get('/table', [CVTableController::class, 'show'])->name('cvs.table');