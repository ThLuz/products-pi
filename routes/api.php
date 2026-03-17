<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImportProductsController;
use App\Http\Controllers\StatisticsController;

Route::post('/products/import', ImportProductsController::class);

Route::get('/products', [ProductController::class,'index']);
Route::get('/products/{product}', [ProductController::class,'show']);

Route::patch('/products/{product}', [ProductController::class,'update']);

Route::delete('/products/{product}', [ProductController::class,'destroy']);

Route::get('/statistics', StatisticsController::class);