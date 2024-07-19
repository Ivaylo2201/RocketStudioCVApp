<?php

use App\Http\Controllers\CVFormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('', [CVFormController::class, 'show']);
Route::post('', [CVFormController::class, 'store'])->name('form.submit');