<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MainController;

Route::get('/config/{deviceId}',[MainController::class, 'get_config']);
Route::post('/data/{deviceId}',[MainController::class, 'post_data']);
