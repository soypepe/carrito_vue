<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\UserController;

Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/productos/{producto}', [ProductoController::class, 'show']);

Route::post('/compra', [UserController::class, 'compra']);