<?php

use App\Http\Controllers\CVFormController;
use App\Http\Controllers\CVTableController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\Route;

Route::get('', [CVFormController::class, 'show']);
Route::post('', [CVFormController::class, 'store'])->name('form.submit');
Route::get('/table', [CVTableController::class, 'show'])->name('cvs.table');
Route::post('/add-university', [UniversityController::class, 'store'])->name('add.university');
Route::post('/add-technology', [TechnologyController::class, 'store'])->name('add.technology');