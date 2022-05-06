<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\SizeController;
use App\Http\Controllers\Api\Admin\ColorController;
use App\Http\Controllers\Api\Admin\VendorController;
use App\Http\Controllers\Api\Admin\GiftShopController;
use App\Http\Controllers\Api\Admin\MediaUploadController;
use App\Http\Controllers\Api\Admin\ParentCategoryController;
use App\Http\Controllers\Api\Admin\ProductCategoryController;
use App\Http\Controllers\Api\Admin\ParentSubCategoryController;



/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'media-upload'=> MediaUploadController::class,
    'vendor' => VendorController::class,
    'product-category' => ProductCategoryController::class,
    'parent-category' => ParentCategoryController::class,
    'parent-sub-category' => ParentSubCategoryController::class,
    'color' => ColorController::class,
    'size' => SizeController::class,
    'gift-shop' => GiftShopController::class,

]);


