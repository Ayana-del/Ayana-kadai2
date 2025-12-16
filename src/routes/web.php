<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; //コントローラーの読み込み
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//1.商品一覧
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
//2.検索
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
//3.商品登録画面
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
//4.商品登録詳細
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');
//5.商品詳細・変更フォーム
Route::get('/products/{productId}', [ProductController::class, 'show'])->name('products.show');
//6.商品更新処理
Route::match(['patch'], '/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');
//7.削除処理
Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/', function () {
    return view('welcome');
});
