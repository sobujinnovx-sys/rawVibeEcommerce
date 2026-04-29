<?php

use App\Http\Controllers\Api\ProductImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product Images API Routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/products/{product}/images/upload', [ProductImageController::class, 'upload'])->name('api.products.images.upload');
    Route::get('/products/{product}/images', [ProductImageController::class, 'index'])->name('api.products.images.index');
    Route::delete('/product-images/{productImage}', [ProductImageController::class, 'destroy'])->name('api.product-images.destroy');
    Route::patch('/product-images/{productImage}', [ProductImageController::class, 'update'])->name('api.product-images.update');
    Route::post('/products/{product}/images/reorder', [ProductImageController::class, 'reorder'])->name('api.products.images.reorder');
});
