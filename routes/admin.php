<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\MediaUploadController;
use App\Http\Controllers\Api\Admin\ProductCategoryController;
use App\Http\Controllers\Api\Admin\ParentCategoryController;
use App\Http\Controllers\Api\Admin\VendorController;



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


//Product categories Routes here
Route::post('create-product-category', [ProductCategoryController::class, 'create']);
Route::get('product-categories', [ProductCategoryController::class, 'index']);
Route::post('edit-product-category/{id}', [ProductCategoryController::class, 'update']);
Route::delete('delete-product-category/{id}', [ProductCategoryController::class, 'delete']);
Route::apiResources([
    'media-upload'=> MediaUploadController::class,
    'vendor' => VendorController::class,
]);
Route::post('category-subcategories/{category_id}', [ProductCategoryController::class, 'GetSubcategories']);


//Parent Category Routes defined here
Route::get('parent-category', [ParentCategoryController::class, 'index']);
Route::post('create-parent-category', [ParentCategoryController::class, 'create']);
Route::post('edit-parent-category/{id}', [ParentCategoryController::class ,'update']);
Route::delete('delete-parent-category/{id}', [ParentCategoryController::class, 'destroy']);

