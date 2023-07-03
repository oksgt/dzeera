<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/test', [TestController::class, 'index']);

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('brands', [\App\Http\Controllers\BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/create', [\App\Http\Controllers\BrandController::class, 'create'])->name('brands.create');
    Route::post('brands/save', [\App\Http\Controllers\BrandController::class, 'save'])->name('brands.save');
    Route::get('brands/{brand}/edit', [\App\Http\Controllers\BrandController::class, 'edit'])->name('brands.edit');
    Route::put('brands/{brand}', [\App\Http\Controllers\BrandController::class, 'update'])->name('brands.update');
    Route::get('brands/{brand}/delete', [\App\Http\Controllers\BrandController::class, 'delete'])->name('brands.delete');
    Route::delete('brands/remove', [\App\Http\Controllers\BrandController::class, 'remove'])->name('brands.remove');

    Route::get('category', [\App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::get('category/getData', [\App\Http\Controllers\CategoryController::class, 'getData'])->name('category.list');
    Route::get('category/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
    Route::post('category/save', [\App\Http\Controllers\CategoryController::class, 'save'])->name('category.save');
    Route::get('category/{category}/edit', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
    Route::put('category/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::get('category/{category}/delete', [\App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');
    Route::delete('category/remove', [\App\Http\Controllers\CategoryController::class, 'remove'])->name('category.remove');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
