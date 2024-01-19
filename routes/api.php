<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::middleware("randomUser")
    ->resource('products', ProductController::class);
