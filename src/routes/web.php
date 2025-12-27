<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

// --- 公開ルート（ログイン不要） ---
Route::get('/', function () {
    return view('welcome');
});

// --- 認証必須ルート ---
Route::middleware(['auth'])->group(function () {

    //　プロフィール未登録の人でもアクセスできるルート（登録画面）
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');

    // プロフィール登録が「済んでいる」人だけがアクセスできるルート
    Route::middleware(['ensure.profile'])->group(function () {

        // 商品一覧
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');

        Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{productId}', [ProductController::class, 'show'])->name('products.show');
        Route::match(['patch'], '/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
    });
});
