<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CityController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\SizeController;
use App\Http\Controllers\Api\Admin\ColorController;
use App\Http\Controllers\Api\Admin\CouponController;
use App\Http\Controllers\Api\Admin\OrdersController;
use App\Http\Controllers\Api\Admin\VendorController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\CustomerController;
use App\Http\Controllers\Api\Admin\GiftShopController;
use App\Http\Controllers\Api\Admin\CouponTypeController;
use App\Http\Controllers\Api\Admin\OrderItemsController;
use App\Http\Controllers\Api\Admin\MediaUploadController;
use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Controllers\Api\Admin\ParentCategoryController;
use App\Http\Controllers\Api\Admin\ProductCategoryController;
use App\Http\Controllers\Api\Vendor\VendorDashboardController;
use App\Http\Controllers\Api\Admin\ParentSubCategoryController;
use App\Http\Controllers\Api\Admin\RoleController;



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

Route::controller(AuthController::class)->group(function(){
    Route::POST('/login', 'login');
    Route::POST('auth/password/reset', 'reset')->name('password.reset');
    Route::POST('forgot-password', 'forgotPassword');
});


//password Reset
// Route::POST('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.reset');
// Route::POST('auth/password/reset', [ForgotPasswordController::class, 'reset'])->name('password.reset');


Route::middleware('admin')->get('/user', function (Request $request) {
    return $request->user();
});

<<<<<<< HEAD
Route::apiResources([
    'media-upload'=> MediaUploadController::class,
    'vendor' => VendorController::class,
    'product-category' => ProductCategoryController::class,
    'parent-category' => ParentCategoryController::class,
    'parent-sub-category' => ParentSubCategoryController::class,
    'color' => ColorController::class,
    'size' => SizeController::class,
    'gift-shop' => GiftShopController::class,
    'product' => ProductController::class,
    'city' => CityController::class,
    'coupon' => CouponController::class,
    'coupon-type' => CouponTypeController::class,
    'order' => OrdersController::class,
    'role' => RoleController::class,
    'admin-dashboard' => AdminDashboardController::class,
    'customers' => CustomerController::class,
]);
=======
Route::group(['middleware' => 'auth:sanctum'], function(){
    
    Route::apiResources([
        'media-upload'=> MediaUploadController::class,
        'vendor' => VendorController::class,
        'product-category' => ProductCategoryController::class,
        'parent-category' => ParentCategoryController::class,
        'parent-sub-category' => ParentSubCategoryController::class,
        'color' => ColorController::class,
        'size' => SizeController::class,
        'gift-shop' => GiftShopController::class,
        'product' => ProductController::class,
        'city' => CityController::class,
        'coupon' => CouponController::class,
        'coupon-type' => CouponTypeController::class,
        'order' => OrdersController::class,
        'order-item' => OrderItemsController::class,
        'admin-dashboard' => AdminDashboardController::class,
        'vendor-dashboard' => VendorDashboardController::class,
        'customers' => CustomerController::class,
    ]);
>>>>>>> 2d0856653e3c6588d221e33922f1a8f69cc0f9a5

    Route::controller(CustomerController::class)->group(function(){
        Route::GET('customers-latest', 'latestUsers');
    });
    
    Route::controller(AuthController::class)->group(function(){
        Route::POST('register', 'store');
        Route::POST('resend-register-email', 'resendLink');
    });


    //Vendor All Products
    Route::controller(VendorController::class)->group(function(){
        Route::GET('vendor-products/{slug}', 'vendorAllProducts');
      });


      
});



