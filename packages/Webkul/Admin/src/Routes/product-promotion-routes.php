<?php

use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\ProductPromotionController;

Route::group(['middleware' => ['admin'], 'prefix' => config('app.admin_url') . ''], function () {
    Route::prefix('customers')->group(function () {
        Route::prefix('promotions')->group(function () {
            Route::get('/', [ProductPromotionController::class, 'index'])->name('admin.promotions.index');
            Route::get('/create', [ProductPromotionController::class, 'create'])->name('admin.promotions.create');
            Route::post('/', [ProductPromotionController::class, 'store'])->name('admin.promotions.store');
            Route::get('{id}/edit', [ProductPromotionController::class, 'edit'])->name('admin.promotions.edit');
            Route::put('{id}', [ProductPromotionController::class, 'update'])->name('admin.promotions.update');
            Route::delete('{id}', [ProductPromotionController::class, 'destroy'])->name('admin.promotions.destroy');
        });
    });
});
