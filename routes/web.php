<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-create', [TestController::class, 'testcreate']);
Route::get('/cv/{id}', [TestController::class, 'show']);
