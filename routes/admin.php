<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductSubcategoryController;


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

//Product Subcategory Routes here
Route::post('create-product-subcategory/{ProductCategoryId}', [ProductSubcategoryController::class, 'create']);
Route::get('product-subcategories', [ProductSubcategoryController::class, 'index']);
Route::post('edit-product-subcategory/{ProductCategoryId}/{id}', [ProductSubcategoryController::class, 'update']);
Route::delete('delete-product-subcategory/{id}', [ProductSubcategoryController::class, 'delete']);