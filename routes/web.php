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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
    Route::get('category/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
    Route::post('category/save', [\App\Http\Controllers\CategoryController::class, 'save'])->name('category.save');
    Route::get('category/{category}/edit', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
    Route::put('category/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::get('category/{category}/delete', [\App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');
    Route::delete('category/remove', [\App\Http\Controllers\CategoryController::class, 'remove'])->name('category.remove');
    Route::get('category/list/{brand_id}', [\App\Http\Controllers\CategoryController::class, 'listByBrand']);

    Route::get('product', [\App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::get('product/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
    Route::post('product/save', [\App\Http\Controllers\ProductController::class, 'save'])->name('product.save');

    Route::get('product/{product}/edit', [\App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::post('product/{product}', [\App\Http\Controllers\ProductController::class, 'updateProduct'])->name('product.update');

    Route::get('product/{product}/delete', [\App\Http\Controllers\ProductController::class, 'delete'])->name('product.delete');
    Route::delete('product/remove', [\App\Http\Controllers\ProductController::class, 'remove'])->name('product.remove');
    Route::get('product/{product}/view', [\App\Http\Controllers\ProductController::class, 'view'])->name('product.view');
    Route::get('product/{product}/detail', [\App\Http\Controllers\ProductController::class, 'detail'])->name('product.detail');

    Route::get('product/{product}/variant', [\App\Http\Controllers\ProductController::class, 'variant'])->name('product.variant');
    Route::get('product/{product}/variant/add', [\App\Http\Controllers\ProductController::class, 'variant_add'])->name('product.variant.add');
    Route::post('product/{product}/variant/save', [\App\Http\Controllers\ProductController::class, 'variant_save'])->name('product.variant.save');

    Route::get('product/{product}/{ProductOption}/variant/edit', [\App\Http\Controllers\ProductController::class, 'variant_edit'])->name('product.variant.edit');
    Route::post('product/{ProductOption}/variant/update', [\App\Http\Controllers\ProductController::class, 'variant_update'])->name('product.variant.update');
    Route::get('product/{ProductOption}/variant/delete', [\App\Http\Controllers\ProductController::class, 'variant_delete'])->name('product.variant.delete');
    Route::post('product/variant/remove', [\App\Http\Controllers\ProductController::class, 'variant_remove'])->name('product.variant.remove');

    Route::get('product/{product}/images', [\App\Http\Controllers\ProductController::class, 'images'])->name('product.images');
    Route::post('product/images/upload', [\App\Http\Controllers\ProductController::class, 'images_upload'])->name('product.images.upload');
    Route::post('product/images/setThumbnail', [\App\Http\Controllers\ProductController::class, 'set_thumbnail'])->name('product.images.setThumbnail');
    Route::post('product/images/remove', [\App\Http\Controllers\ProductController::class, 'deleteImage'])->name('product.images.delete');

    Route::get('product/{product}/options', [\App\Http\Controllers\ProductController::class, 'options'])->name('product.options');

    Route::post('product/color/save', [\App\Http\Controllers\ProductController::class, 'colorSave'])->name('product.color.create.save');
    Route::post('product/color/update', [\App\Http\Controllers\ProductController::class, 'color_update'])->name('product.color.create.update');
    Route::post('product/color/remove', [\App\Http\Controllers\ProductController::class, 'color_remove'])->name('product.color.create.remove');

    Route::get('product/{product}/colorCreate', [\App\Http\Controllers\ProductController::class, 'colorCreate'])->name('product.color.create');
    Route::get('product/{product}/{ProductColorOption}/colorEdit', [\App\Http\Controllers\ProductController::class, 'colorEdit'])->name('product.color.edit');
    Route::get('product/{product}/{ProductColorOption}/colorDelete', [\App\Http\Controllers\ProductController::class, 'colorDelete'])->name('product.color.delete');


    Route::get('product/{product}/sizeCreate', [\App\Http\Controllers\ProductController::class, 'sizeCreate'])->name('product.size.create');
    Route::post('product/size/save', [\App\Http\Controllers\ProductController::class, 'sizeSave'])->name('product.size.create.save');
    Route::post('product/size/update', [\App\Http\Controllers\ProductController::class, 'size_update'])->name('product.size.create.update');
    Route::post('product/size/remove', [\App\Http\Controllers\ProductController::class, 'size_remove'])->name('product.size.create.remove');
    Route::get('product/{product}/{ProductSizeOption}/sizeEdit', [\App\Http\Controllers\ProductController::class, 'sizeEdit'])->name('product.size.edit');
    Route::get('product/{product}/{ProductSizeOption}/sizeDelete', [\App\Http\Controllers\ProductController::class, 'sizeDelete'])->name('product.size.delete');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');


    Route::get('/bank-accounts', [\App\Http\Controllers\BankAccountController::class, 'index'])->name('bank-accounts.index');
    Route::get('/bank-accounts/create', [\App\Http\Controllers\BankAccountController::class, 'create'])->name('bank-accounts.create');
    Route::post('/bank-accounts', [\App\Http\Controllers\BankAccountController::class, 'store'])->name('bank-accounts.store');
    Route::get('/bank-accounts/{bankAccount}/edit', [\App\Http\Controllers\BankAccountController::class, 'edit'])->name('bank-accounts.edit');
    Route::post('/bank-accounts/{bankAccount}', [\App\Http\Controllers\BankAccountController::class, 'update'])->name('bank-accounts.update');
    Route::get('/bank-accounts/{bankAccount}/delete', [\App\Http\Controllers\BankAccountController::class, 'delete'])->name('bank-accounts.delete');
    Route::delete('/bank-accounts/{bankAccount}', [\App\Http\Controllers\bankAccountController::class, 'destroy'])->name('bank-accounts.destroy');

    Route::get('/vouchers', [\App\Http\Controllers\VoucherController::class, 'index'])->name('vouchers.index');
    Route::get('/vouchers/create', [\App\Http\Controllers\VoucherController::class, 'create'])->name('vouchers.create');
    Route::post('/vouchers', [\App\Http\Controllers\VoucherController::class, 'store'])->name('vouchers.store');
    Route::get('/vouchers/{voucher}/edit', [\App\Http\Controllers\VoucherController::class, 'edit'])->name('vouchers.edit');
    Route::post('/vouchers/{voucher}', [\App\Http\Controllers\VoucherController::class, 'update'])->name('vouchers.update');
    Route::get('/vouchers/{voucher}/delete', [\App\Http\Controllers\VoucherController::class, 'delete'])->name('vouchers.delete');
    Route::delete('/vouchers/{voucher}', [\App\Http\Controllers\VoucherController::class, 'destroy'])->name('vouchers.destroy');

    Route::get('/gifts', [\App\Http\Controllers\GiftController::class, 'index'])->name('gifts.index');
    Route::get('/gifts/create', [\App\Http\Controllers\GiftController::class, 'create'])->name('gifts.create');
    Route::get('/gifts/getProductOption/{productId}', [\App\Http\Controllers\GiftController::class, 'getProductOptions'])->name('gifts.getProductOptions');
    Route::post('/gifts', [\App\Http\Controllers\GiftController::class, 'store'])->name('gifts.store');
    Route::get('/gifts/{gift}/edit', [\App\Http\Controllers\GiftController::class, 'edit'])->name('gifts.edit');
    Route::post('/gifts/{gift}', [\App\Http\Controllers\GiftController::class, 'update'])->name('gifts.update');
    Route::get('/gifts/{gift}/delete', [\App\Http\Controllers\GiftController::class, 'delete'])->name('gifts.delete');
    Route::delete('/gifts/{gift}', [\App\Http\Controllers\GiftController::class, 'destroy'])->name('gifts.destroy');
    Route::post('/gifts/changeSetting', [\App\Http\Controllers\GiftController::class, 'changeSetting'])->name('gifts.changeSetting');

    Route::get('/bannerImage', [\App\Http\Controllers\BannerImageController::class, 'index'])->name('bannerImage.index');
    Route::post('bannerImage/upload', [\App\Http\Controllers\BannerImageController::class, 'images_upload'])->name('bannerImage.upload');
    Route::post('bannerImage/remove', [\App\Http\Controllers\BannerImageController::class, 'deleteImage'])->name('bannerImage.delete');


    Route::get('/social-media', [\App\Http\Controllers\SocialMediaController::class, 'index'])->name('social-media.index');
    Route::get('/social-media/create', [\App\Http\Controllers\SocialMediaController::class, 'add'])->name('social-media.create');
    Route::post('/social-media/store', [\App\Http\Controllers\SocialMediaController::class, 'store'])->name('social-media.save');
    Route::get('/social-media/{socialMedia}', [\App\Http\Controllers\SocialMediaController::class, 'detail'])->name('social-media.detail');
    Route::post('/social-media/{socialMedia}/update', [\App\Http\Controllers\SocialMediaController::class, 'update'])->name('social-media.update');
    Route::get('/social-media/{socialMedia}/delete', [\App\Http\Controllers\SocialMediaController::class, 'delete'])->name('social-media.delete');
    Route::delete('/social-media/remove', [\App\Http\Controllers\SocialMediaController::class, 'remove'])->name('social-media.remove');

    Route::get('/video-embedded', [\App\Http\Controllers\VideoEmbedController::class, 'index'])->name('video-embedded.index');
    Route::get('/video-embedded/create', [\App\Http\Controllers\VideoEmbedController::class, 'add'])->name('video-embedded.create');
    Route::post('/video-embedded/store', [\App\Http\Controllers\VideoEmbedController::class, 'store'])->name('video-embedded.save');
    Route::get('/video-embedded/{videoEmbed}', [\App\Http\Controllers\VideoEmbedController::class, 'detail'])->name('video-embedded.detail');
    Route::post('/video-embedded/{videoEmbed}/update', [\App\Http\Controllers\VideoEmbedController::class, 'update'])->name('video-embedded.update');
    Route::get('/video-embedded/{videoEmbed}/delete', [\App\Http\Controllers\VideoEmbedController::class, 'delete'])->name('video-embedded.delete');
    Route::delete('/video-embedded/remove', [\App\Http\Controllers\VideoEmbedController::class, 'remove'])->name('video-embedded.remove');
});
